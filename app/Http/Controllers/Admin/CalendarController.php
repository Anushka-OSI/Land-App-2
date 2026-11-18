<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\RequiresAllLanguages;
use App\Http\Controllers\Controller;
use App\Models\CalendarEntry;
use App\Services\SriLankaHolidaySync;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Throwable;

/**
 * Admin → Event Calendar
 *  - Department events, special holidays and special working days: add / edit / delete (all 3 languages).
 *  - Public holidays and Poya days: added automatically from the Sri Lanka holiday calendar;
 *    they can be hidden from the website (e.g. when a holiday is cancelled) and synced on demand.
 */
class CalendarController extends Controller
{
    use RequiresAllLanguages;

    public function index(Request $request)
    {
        $period = in_array($request->period, ['upcoming', 'past', 'all'], true) ? $request->period : 'upcoming';
        $today = today();

        $entries = CalendarEntry::query()
            ->when($period === 'upcoming', fn ($q) => $q->where(fn ($q) => $q
                ->whereDate('end_date', '>=', $today)
                ->orWhere(fn ($q) => $q->whereNull('end_date')->whereDate('start_date', '>=', $today))))
            ->when($period === 'past', fn ($q) => $q->whereDate('start_date', '<', $today)
                ->where(fn ($q) => $q->whereNull('end_date')->orWhereDate('end_date', '<', $today)))
            ->when(array_key_exists((string) $request->type, CalendarEntry::TYPES), fn ($q) => $q->where('type', $request->type))
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($q) => $q
                ->where('title_en', 'like', '%' . $request->q . '%')
                ->orWhere('title_si', 'like', '%' . $request->q . '%')
                ->orWhere('title_ta', 'like', '%' . $request->q . '%')))
            ->when($period === 'past', fn ($q) => $q->orderByDesc('start_date'), fn ($q) => $q->orderBy('start_date'))
            ->orderBy('start_time')
            ->orderBy('id')
            ->paginate(30)
            ->withQueryString();

        $lastSynced = SriLankaHolidaySync::lastSyncedAt();

        return view('admin.calendar.index', compact('entries', 'period', 'lastSynced'));
    }

    public function create(Request $request)
    {
        $type = in_array($request->type, CalendarEntry::ADMIN_TYPES, true) ? $request->type : CalendarEntry::TYPE_EVENT;

        return view('admin.calendar.form', ['entry' => new CalendarEntry([
            'type' => $type,
            'start_date' => today(),
            'is_published' => true,
        ])]);
    }

    public function store(Request $request)
    {
        $entry = CalendarEntry::create($this->validated($request) + ['source' => CalendarEntry::SOURCE_ADMIN]);

        return redirect()->route('admin.calendar.index')
            ->with('success', "\"{$entry->title_en}\" added to the calendar.");
    }

    public function edit(CalendarEntry $calendar)
    {
        $this->ensureEditable($calendar);

        return view('admin.calendar.form', ['entry' => $calendar]);
    }

    public function update(Request $request, CalendarEntry $calendar)
    {
        $this->ensureEditable($calendar);
        $calendar->update($this->validated($request));

        return redirect()->route('admin.calendar.index')->with('success', 'Calendar entry updated.');
    }

    public function destroy(CalendarEntry $calendar)
    {
        if ($calendar->isAuto()) {
            return back()->with('success', 'Public holidays and Poya days come from the Sri Lanka holiday calendar. Hide it instead of deleting it.');
        }

        $calendar->delete();

        return redirect()->route('admin.calendar.index')->with('success', 'Calendar entry deleted.');
    }

    /** Show / hide an entry on the website (mainly for automatic holidays). */
    public function toggleVisibility(CalendarEntry $calendar)
    {
        $calendar->update(['is_published' => ! $calendar->is_published]);

        return back()->with('success', "\"{$calendar->title_en}\" is now " . ($calendar->is_published ? 'shown on' : 'hidden from') . ' the website.');
    }

    /** Download the latest public holidays and Poya days now. */
    public function sync(SriLankaHolidaySync $sync)
    {
        try {
            $counts = $sync->sync();
        } catch (Throwable $e) {
            report($e);

            return back()->withErrors(['sync' => 'Could not update the holidays: ' . $e->getMessage() . ' Please try again later.']);
        }

        return back()->with('success', "Holidays and Poya days updated – {$counts['added']} added, {$counts['updated']} changed, {$counts['removed']} removed.");
    }

    private function ensureEditable(CalendarEntry $entry): void
    {
        abort_if($entry->isAuto(), 403, 'Public holidays and Poya days are updated automatically and cannot be edited.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'type' => ['required', Rule::in(CalendarEntry::ADMIN_TYPES)],
            'start_date' => ['required', 'date_format:Y-m-d'],
            'end_date' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:start_date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'title_en' => 'nullable|string|max:255',
            'title_si' => 'nullable|string|max:255',
            'title_ta' => 'nullable|string|max:255',
            'description_en' => 'nullable|string|max:2000',
            'description_si' => 'nullable|string|max:2000',
            'description_ta' => 'nullable|string|max:2000',
        ], [
            'end_date.after_or_equal' => 'The end date must be on or after the start date.',
        ], [
            'start_date' => 'date',
            'end_date' => 'end date',
            'start_time' => 'time',
        ]);

        foreach (['title_en', 'title_si', 'title_ta', 'description_en', 'description_si', 'description_ta'] as $field) {
            $data[$field] = filled($data[$field] ?? null) ? trim($data[$field]) : null;
        }

        $this->checkAllLanguages($data, [
            'Title' => self::suffixedColumns('title'),
        ], [
            'Description' => self::suffixedColumns('description'),
        ]);

        $start = Carbon::parse($data['start_date']);
        $end = filled($data['end_date'] ?? null) ? Carbon::parse($data['end_date']) : null;

        if ($end && $start->diffInDays($end) + 1 > CalendarEntry::MAX_DAYS) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'end_date' => 'An entry can cover at most ' . CalendarEntry::MAX_DAYS . ' days.',
            ]);
        }

        // One-day entries are stored without an end date; a time only makes sense for events
        $data['end_date'] = $end && $end->gt($start) ? $end->toDateString() : null;
        if ($data['type'] !== CalendarEntry::TYPE_EVENT) {
            $data['start_time'] = null;
        }

        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }
}
