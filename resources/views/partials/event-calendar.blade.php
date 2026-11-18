{{--
    Event calendar – on every page (layouts/app): a tab fixed to the right side of the screen
    that opens the calendar and the upcoming list in a full-screen view.
    Public holidays and Poya days are updated automatically; department events,
    special holidays and special working days are added in Admin → Event Calendar.
--}}
@php
    extract(\App\Support\EventCalendar::viewData());

    $calendarTypes = collect(\App\Models\CalendarEntry::TYPES)->map(fn ($label) => __($label))->all();
    $calendarStrings = [
        'types' => $calendarTypes,
        'previous' => __('Previous month'),
        'next' => __('Next month'),
        'today' => __('Today'),
        'nothing' => __('No events or holidays on this day.'),
        'selectDay' => __('Select a date to see its events and holidays.'),
        'error' => __('The calendar could not be loaded. Please try again.'),
        'loading' => __('Loading…'),
        // Month and day names from Carbon (browsers do not all have Sinhala / Tamil names)
        'months' => collect(range(1, 12))->map(fn ($m) => \Carbon\Carbon::create(2023, $m, 1)->locale(app()->getLocale())->isoFormat('MMMM'))->all(),
        'monthsShort' => collect(range(1, 12))->map(fn ($m) => \Carbon\Carbon::create(2023, $m, 1)->locale(app()->getLocale())->isoFormat('MMM'))->all(),
        'weekdays' => collect(range(1, 7))->map(fn ($d) => \Carbon\Carbon::create(2023, 1, $d)->locale(app()->getLocale())->isoFormat('dddd'))->all(),
        // Tamil short day names are whole words, so the 1–2 letter forms are used for the column headings
        'weekdaysShort' => collect(range(1, 7))->map(fn ($d) => \Carbon\Carbon::create(2023, 1, $d)->locale(app()->getLocale())
            ->isoFormat(app()->getLocale() === 'ta' ? 'dd' : 'ddd'))->all(),
    ];
@endphp

{{-- Tab on the right side of every page --}}
@php
    $calendarNext = $calendarUpcoming->first();
    // something on the calendar within the next 7 days → small dot on the tab
    $calendarSoon = $calendarNext && $calendarNext->start_date->lte(today()->addDays(7));
@endphp
<div class="cal-fab-wrap">
    @if($calendarNext)
        <button type="button" class="cal-teaser cal-teaser--{{ $calendarNext->type }}" data-cal-open data-cal-teaser tabindex="-1" aria-hidden="true">
            <span class="cal-teaser-label">{{ __('Coming up') }}</span>
            <span class="cal-teaser-name">{{ $calendarNext->titleIn() }}</span>
            <span class="cal-teaser-date">
                {{ $calendarNext->start_date->isToday() ? __('Today') : $calendarNext->start_date->translatedFormat('l, j F') }}
            </span>
        </button>
    @endif

    <button type="button" class="cal-fab" data-cal-open aria-haspopup="dialog" aria-controls="event-calendar" aria-expanded="false"
        title="{{ __('Event Calendar') }}">
        <span class="cal-fab-icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <span class="cal-fab-date">{{ today()->format('j') }}</span>
            @if($calendarSoon)
                <span class="cal-fab-dot"></span>
            @endif
        </span>
        <span class="cal-fab-label">{{ __('Event Calendar') }}</span>
    </button>
</div>

{{-- Full-screen calendar --}}
<div class="cal-modal" id="event-calendar" role="dialog" aria-modal="true" aria-labelledby="event-calendar-title" hidden>
    <div class="cal-backdrop" data-cal-close></div>

    <div class="cal-panel" tabindex="-1">
        <header class="cal-panel-head">
            <div>
                <h2 class="cal-panel-title" id="event-calendar-title">{{ __('Event Calendar') }}</h2>
                <p class="cal-panel-sub">{{ __('Upcoming department events, public holidays and Poya days') }}</p>
            </div>
            <button type="button" class="cal-close" data-cal-close aria-label="{{ __('Close') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </header>

        <div class="cal-layout">
            {{-- Month view --}}
            <div class="cal-card"
                data-calendar
                data-endpoint="{{ route('calendar.month') }}"
                data-month="{{ $calendarMonth }}"
                data-today="{{ today()->toDateString() }}">
                <script type="application/json" class="cal-strings">@json($calendarStrings)</script>
                <script type="application/json" class="cal-initial">@json($calendarEntries)</script>
                <div class="cal-head">
                    <button type="button" class="cal-nav" data-cal-prev aria-label="{{ __('Previous month') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <div class="cal-head-center">
                        <h3 class="cal-month-title" aria-live="polite"></h3>
                        <button type="button" class="cal-today-btn" data-cal-today>{{ __('Today') }}</button>
                    </div>
                    <button type="button" class="cal-nav" data-cal-next aria-label="{{ __('Next month') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>

                <div class="cal-weekdays" aria-hidden="true"></div>
                <div class="cal-days"></div>

                <ul class="cal-legend" aria-label="{{ __('Calendar legend') }}">
                    @foreach($calendarTypes as $type => $label)
                        <li><span class="cal-dot cal-dot--{{ $type }}" aria-hidden="true"></span>{{ $label }}</li>
                    @endforeach
                </ul>

                <div class="cal-detail" aria-live="polite"></div>
            </div>

            {{-- Upcoming list --}}
            <div class="cal-upcoming">
                <h3 class="cal-upcoming-title">{{ __('Upcoming') }}</h3>

                @forelse($calendarUpcoming as $entry)
                    @php
                        $first = $entry->start_date;
                        $last = $entry->lastDate();
                        $isRange = $last->gt($first);
                    @endphp
                    <article class="cal-up-item cal-up-item--{{ $entry->type }}">
                        <div class="cal-up-date" aria-hidden="true">
                            <span class="cal-up-day">{{ $first->format('d') }}</span>
                            <span class="cal-up-month">{{ $first->translatedFormat('M') }}</span>
                        </div>
                        <div class="cal-up-body">
                            <span class="cal-type cal-type--{{ $entry->type }}">{{ $calendarTypes[$entry->type] ?? '' }}</span>
                            <h4 class="cal-up-name">{{ $entry->titleIn() }}</h4>
                            <p class="cal-up-meta">
                                <time datetime="{{ $first->toDateString() }}">{{ $first->translatedFormat('l, j F Y') }}</time>
                                @if($isRange)
                                    – <time datetime="{{ $last->toDateString() }}">{{ $last->translatedFormat('j F Y') }}</time>
                                @endif
                                @if($entry->timeLabel())
                                    · {{ $entry->timeLabel() }}
                                @endif
                            </p>
                            @if($entry->descriptionIn())
                                <p class="cal-up-desc">{{ \Illuminate\Support\Str::limit($entry->descriptionIn(), 140) }}</p>
                            @endif
                        </div>
                    </article>
                @empty
                    <p class="cal-empty">{{ __('No upcoming events or holidays.') }}</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
