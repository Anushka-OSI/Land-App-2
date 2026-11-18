<?php

namespace App\Support;

use App\Models\CalendarEntry;
use App\Services\SriLankaHolidaySync;
use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;
use Throwable;

/** Data for the event calendar shown on every page of the website. */
class EventCalendar
{
    /** Upcoming items listed next to the calendar. */
    public const UPCOMING_COUNT = 8;

    /** Published entries on any day of the month, in the visitor's language. */
    public static function monthEntries(CarbonInterface $month): array
    {
        $from = $month->copy()->startOfMonth();
        $to = $month->copy()->endOfMonth();

        return CalendarEntry::published()
            ->between($from, $to)
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->orderBy('id')
            ->get()
            ->map(fn (CalendarEntry $entry) => $entry->toCalendarArray())
            ->all();
    }

    /** The next few events, holidays, Poya days and special working days (today included). */
    public static function upcoming(int $count = self::UPCOMING_COUNT)
    {
        $today = today();

        return CalendarEntry::published()
            ->where(fn ($q) => $q
                ->whereDate('end_date', '>=', $today)
                ->orWhere(fn ($q) => $q->whereNull('end_date')->whereDate('start_date', '>=', $today)))
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->orderBy('id')
            ->take($count)
            ->get();
    }

    /** Everything the partial needs. Never breaks the page if the calendar table is not ready. */
    public static function viewData(): array
    {
        try {
            SriLankaHolidaySync::syncInBackgroundIfStale();

            $month = today()->startOfMonth();

            return [
                'calendarMonth' => $month->format('Y-m'),
                'calendarEntries' => self::monthEntries($month),
                'calendarUpcoming' => self::upcoming(),
            ];
        } catch (Throwable $e) {
            report($e);

            return ['calendarMonth' => today()->format('Y-m'), 'calendarEntries' => [], 'calendarUpcoming' => collect()];
        }
    }
}
