<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * One item on the website's event calendar (see partials/event-calendar).
 *
 *  - Public holidays and Poya days are added automatically from the Sri Lanka holiday calendar
 *    (App\Services\SriLankaHolidaySync). The admin can only hide / show these.
 *  - Department events, special holidays and special working days are added by the admin
 *    in English, Sinhala and Tamil.
 */
class CalendarEntry extends Model
{
    public const TYPE_EVENT = 'event';
    public const TYPE_HOLIDAY = 'holiday';
    public const TYPE_POYA = 'poya';
    public const TYPE_SPECIAL_HOLIDAY = 'special_holiday';
    public const TYPE_WORKING_DAY = 'working_day';

    /** All types with their English labels (translated on the website with __()). */
    public const TYPES = [
        self::TYPE_EVENT => 'Department Event',
        self::TYPE_HOLIDAY => 'Public Holiday',
        self::TYPE_POYA => 'Poya Day',
        self::TYPE_SPECIAL_HOLIDAY => 'Special Holiday',
        self::TYPE_WORKING_DAY => 'Special Working Day',
    ];

    /** Types the admin can add. Holidays and Poya days come from the holiday calendar. */
    public const ADMIN_TYPES = [self::TYPE_EVENT, self::TYPE_SPECIAL_HOLIDAY, self::TYPE_WORKING_DAY];

    public const SOURCE_ADMIN = 'admin';
    public const SOURCE_AUTO = 'auto';

    /** Longest event / holiday the admin can add, in days. */
    public const MAX_DAYS = 60;

    protected $fillable = [
        'type', 'source', 'external_uid', 'start_date', 'end_date', 'start_time',
        'title_en', 'title_si', 'title_ta', 'description_en', 'description_si', 'description_ta',
        'is_published',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_published' => 'boolean',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /** Entries on any day between $from and $to (inclusive). */
    public function scopeBetween(Builder $query, CarbonInterface $from, CarbonInterface $to): Builder
    {
        return $query->whereDate('start_date', '<=', $to)
            ->where(fn ($q) => $q
                ->whereDate('end_date', '>=', $from)
                ->orWhere(fn ($q) => $q->whereNull('end_date')->whereDate('start_date', '>=', $from)));
    }

    public function isAuto(): bool
    {
        return $this->source === self::SOURCE_AUTO;
    }

    public function lastDate(): Carbon
    {
        return $this->end_date ?? $this->start_date;
    }

    public function typeLabel(): string
    {
        return self::TYPES[$this->type] ?? ucfirst($this->type);
    }

    /**
     * Title in $lang. Admin entries have all three languages; holiday names from the
     * holiday calendar are in English and translated with the site's language files.
     */
    public function titleIn(?string $lang = null): string
    {
        $lang ??= app()->getLocale();

        return $this->getAttribute("title_{$lang}") ?: __($this->title_en, [], $lang);
    }

    public function descriptionIn(?string $lang = null): ?string
    {
        $lang ??= app()->getLocale();

        $english = $this->description_en;

        return $this->getAttribute("description_{$lang}") ?: ($english ? __($english, [], $lang) : null);
    }

    /** "9:30 AM" or null */
    public function timeLabel(): ?string
    {
        return $this->start_time ? Carbon::parse($this->start_time)->format('g:i A') : null;
    }

    /** Data sent to the calendar on the website. */
    public function toCalendarArray(?string $lang = null): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'start' => $this->start_date->toDateString(),
            'end' => $this->lastDate()->toDateString(),
            'time' => $this->timeLabel(),
            'title' => $this->titleIn($lang),
            'description' => $this->descriptionIn($lang),
        ];
    }
}
