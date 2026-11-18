<?php

namespace App\Services;

use App\Models\CalendarEntry;
use App\Models\SiteSetting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

/**
 * Keeps the public holidays and Poya days on the event calendar up to date.
 *
 * Source: the public "Holidays in Sri Lanka" calendar (iCalendar feed, no API key needed).
 * It lists the holidays declared by the Government for the past few years and the coming year,
 * including Poya days and Muslim holidays whose dates are confirmed later.
 * Only public holidays are imported (observances like Valentine's Day are skipped).
 *
 * Runs every day from the scheduler (`php artisan calendar:sync-holidays`) and also
 * automatically after a page visit when the last sync is more than a week old,
 * so the calendar stays current even if the scheduler is not set up.
 */
class SriLankaHolidaySync
{
    public const DEFAULT_FEED = 'https://calendar.google.com/calendar/ical/en.lk%23holiday%40group.v.calendar.google.com/public/basic.ics';

    public const LAST_SYNC_KEY = 'calendar_holidays_synced_at';
    private const STALE_AFTER_DAYS = 7;

    /** @return array{added:int, updated:int, removed:int} */
    public function sync(): array
    {
        $holidays = $this->parse($this->download());

        if ($holidays === []) {
            throw new RuntimeException('The holiday calendar returned no holidays.');
        }

        $counts = ['added' => 0, 'updated' => 0, 'removed' => 0];

        DB::transaction(function () use ($holidays, &$counts) {
            foreach ($holidays as $holiday) {
                $entry = CalendarEntry::firstOrNew(['external_uid' => $holiday['uid']]);
                $entry->fill([
                    'type' => $holiday['type'],
                    'source' => CalendarEntry::SOURCE_AUTO,
                    'start_date' => $holiday['start'],
                    'end_date' => $holiday['end'],
                    'title_en' => $holiday['title'],
                    'description_en' => $holiday['description'],
                ]);
                // is_published is left as it is: a holiday the admin hid stays hidden

                if (! $entry->exists) {
                    $entry->is_published = true;
                    $entry->save();
                    $counts['added']++;
                } elseif ($entry->isDirty()) {
                    $entry->save();
                    $counts['updated']++;
                }
            }

            // Holidays the Government cancelled or moved (no longer in the feed)
            $dates = array_column($holidays, 'start');
            $counts['removed'] = CalendarEntry::where('source', CalendarEntry::SOURCE_AUTO)
                ->whereNotIn('external_uid', array_column($holidays, 'uid'))
                ->whereBetween('start_date', [min($dates), max($dates)])
                ->delete();
        });

        SiteSetting::putMany([self::LAST_SYNC_KEY => now()->toIso8601String()]);

        return $counts;
    }

    public static function lastSyncedAt(): ?Carbon
    {
        $value = SiteSetting::many([self::LAST_SYNC_KEY])[self::LAST_SYNC_KEY];

        return $value ? Carbon::parse($value) : null;
    }

    /** Sync after the response has been sent when the last sync is more than a week old. */
    public static function syncInBackgroundIfStale(): void
    {
        try {
            $last = self::lastSyncedAt();
            if ($last && $last->gt(now()->subDays(self::STALE_AFTER_DAYS))) {
                return;
            }
            // try at most once an hour (also stops many visitors starting it at the same time)
            if (! Cache::add('calendar-holiday-sync-lock', true, now()->addHour())) {
                return;
            }

            app()->terminating(function () {
                try {
                    app(self::class)->sync();
                } catch (Throwable $e) {
                    Log::warning('Holiday calendar sync failed: ' . $e->getMessage());
                }
            });
        } catch (Throwable $e) {
            Log::warning('Holiday calendar sync check failed: ' . $e->getMessage());
        }
    }

    private function download(): string
    {
        $response = Http::timeout(20)->retry(2, 1000)
            ->get(config('services.holiday_calendar.url') ?: self::DEFAULT_FEED);

        if (! $response->successful() || ! str_contains($response->body(), 'BEGIN:VCALENDAR')) {
            throw new RuntimeException('Could not download the holiday calendar (HTTP ' . $response->status() . ').');
        }

        return $response->body();
    }

    /**
     * Reads the public holidays from an iCalendar (.ics) file.
     *
     * @return list<array{uid:string, type:string, start:string, end:?string, title:string, description:?string}>
     */
    public function parse(string $ics): array
    {
        // Unfold long lines (continuation lines start with a space or tab)
        $ics = preg_replace("/\r?\n[ \t]/", '', $ics);

        preg_match_all('/BEGIN:VEVENT(.*?)END:VEVENT/s', $ics, $matches);

        $holidays = [];
        foreach ($matches[1] as $block) {
            $fields = [];
            foreach (preg_split('/\r?\n/', trim($block)) as $line) {
                if (preg_match('/^([A-Z-]+)(?:;[^:]*)?:(.*)$/', $line, $m)) {
                    $fields[$m[1]] = self::unescape($m[2]);
                }
            }

            $summary = trim($fields['SUMMARY'] ?? '');
            $description = $fields['DESCRIPTION'] ?? '';
            $status = $fields['STATUS'] ?? 'CONFIRMED';

            if ($summary === '' || empty($fields['UID']) || empty($fields['DTSTART']) || $status === 'CANCELLED') {
                continue;
            }
            if (! str_starts_with($description, 'Public holiday')) {
                continue; // observances (Mother's Day, Valentine's Day …)
            }

            $start = Carbon::createFromFormat('Ymd', substr($fields['DTSTART'], 0, 8))->startOfDay();
            // DTEND is the day after the last day
            $last = isset($fields['DTEND'])
                ? Carbon::createFromFormat('Ymd', substr($fields['DTEND'], 0, 8))->startOfDay()->subDay()
                : $start->copy();

            $tentative = (bool) preg_match('/\(tentative\)/i', $summary) || str_contains($description, 'tentative');
            $title = trim(preg_replace('/\s*\(tentative\)\s*/i', ' ', $summary));

            $holidays[] = [
                'uid' => $fields['UID'],
                'type' => self::isPoya($title) ? CalendarEntry::TYPE_POYA : CalendarEntry::TYPE_HOLIDAY,
                'start' => $start->toDateString(),
                'end' => $last->gt($start) ? $last->toDateString() : null,
                'title' => $title,
                'description' => $tentative ? 'Date is tentative and may change.' : null,
            ];
        }

        return $holidays;
    }

    /** "Vesak Full Moon Poya Day" yes – "Day after Vesak Full Moon Poya Day" no. */
    private static function isPoya(string $title): bool
    {
        return (bool) preg_match('/Full Moon Poya Day$/i', $title) && ! preg_match('/^Day after/i', $title);
    }

    private static function unescape(string $value): string
    {
        return strtr($value, ['\\n' => "\n", '\\N' => "\n", '\\,' => ',', '\\;' => ';', '\\\\' => '\\']);
    }
}
