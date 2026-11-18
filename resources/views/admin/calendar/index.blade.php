@extends('layouts.admin')

@section('title', 'Event Calendar')

@php
    $typeBadges = [
        \App\Models\CalendarEntry::TYPE_EVENT => 'cal-badge-event',
        \App\Models\CalendarEntry::TYPE_HOLIDAY => 'cal-badge-holiday',
        \App\Models\CalendarEntry::TYPE_POYA => 'cal-badge-poya',
        \App\Models\CalendarEntry::TYPE_SPECIAL_HOLIDAY => 'cal-badge-special',
        \App\Models\CalendarEntry::TYPE_WORKING_DAY => 'cal-badge-working',
    ];
@endphp

@section('content')

    <p class="page-intro">
        The calendar is shown at the bottom of every page of the website.
        <strong>Public holidays and Poya days</strong> are updated automatically from the Sri Lanka holiday calendar
        @if($lastSynced)
            (last updated {{ $lastSynced->diffForHumans() }}, {{ $lastSynced->format('j M Y, g:i A') }}).
        @else
            (not downloaded yet – click “Update holidays now”).
        @endif
        Add <strong>department events</strong>, <strong>special holidays</strong> and <strong>special working days</strong> here.
    </p>

    <div class="toolbar">
        <form method="GET" class="filters">
            <select name="period" class="form-input" onchange="this.form.submit()" aria-label="Period">
                <option value="upcoming" @selected($period === 'upcoming')>Upcoming</option>
                <option value="past" @selected($period === 'past')>Past</option>
                <option value="all" @selected($period === 'all')>All dates</option>
            </select>
            <select name="type" class="form-input" onchange="this.form.submit()" aria-label="Type">
                <option value="">All types</option>
                @foreach(\App\Models\CalendarEntry::TYPES as $key => $label)
                    <option value="{{ $key }}" @selected(request('type') === $key)>{{ $label }}</option>
                @endforeach
            </select>
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search titles" class="form-input">
            <button type="submit" class="btn btn-light">Filter</button>
        </form>

        <div class="toolbar-actions">
            <form method="POST" action="{{ route('admin.calendar.sync') }}" class="inline">
                @csrf
                <button type="submit" class="btn btn-light"
                    title="Download the latest public holidays and Poya days now">↻ Update holidays now</button>
            </form>
            <a href="{{ route('admin.calendar.create', ['type' => 'event']) }}" class="btn btn-primary">+ Add Event</a>
            <a href="{{ route('admin.calendar.create', ['type' => 'special_holiday']) }}" class="btn btn-light">+ Special Holiday</a>
            <a href="{{ route('admin.calendar.create', ['type' => 'working_day']) }}" class="btn btn-light">+ Special Working Day</a>
        </div>
    </div>

    <div class="panel table-panel">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th class="actions-col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($entries as $entry)
                    @php $last = $entry->lastDate(); @endphp
                    <tr class="{{ $entry->is_published ? '' : 'row-muted' }}">
                        <td class="nowrap">
                            <strong>{{ $entry->start_date->format('D, j M Y') }}</strong>
                            @if($last->gt($entry->start_date))
                                <div class="cell-sub">to {{ $last->format('D, j M Y') }}
                                    ({{ $entry->start_date->diffInDays($last) + 1 }} days)</div>
                            @endif
                            @if($entry->timeLabel())
                                <div class="cell-sub">{{ $entry->timeLabel() }}</div>
                            @endif
                        </td>
                        <td>
                            @if($entry->isAuto())
                                <span class="cell-title">{{ $entry->title_en }}</span>
                                <div class="cell-sub">
                                    Automatic
                                    @if(__($entry->title_en, [], 'si') === $entry->title_en)
                                        · no Sinhala / Tamil name yet – shown in English
                                    @endif
                                    @if($entry->description_en)
                                        · {{ $entry->description_en }}
                                    @endif
                                </div>
                            @else
                                <a href="{{ route('admin.calendar.edit', $entry) }}" class="cell-title">{{ $entry->title_en }}</a>
                                @if($entry->description_en)
                                    <div class="cell-sub">{{ \Illuminate\Support\Str::limit($entry->description_en, 100) }}</div>
                                @endif
                            @endif
                        </td>
                        <td class="nowrap"><span class="badge {{ $typeBadges[$entry->type] ?? 'badge-muted' }}">{{ $entry->typeLabel() }}</span></td>
                        <td>
                            <span class="badge {{ $entry->is_published ? 'badge-replied' : 'badge-muted' }}">
                                {{ $entry->is_published ? 'Shown' : 'Hidden' }}
                            </span>
                        </td>
                        <td class="actions-col">
                            @unless($entry->isAuto())
                                <a href="{{ route('admin.calendar.edit', $entry) }}" class="btn btn-light btn-sm">Edit</a>
                            @endunless
                            <form method="POST" action="{{ route('admin.calendar.visibility', $entry) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-light btn-sm">{{ $entry->is_published ? 'Hide' : 'Show' }}</button>
                            </form>
                            @unless($entry->isAuto())
                                <form method="POST" action="{{ route('admin.calendar.destroy', $entry) }}" class="inline"
                                    data-confirm="Delete this calendar entry? This cannot be undone.">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            @endunless
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty">No calendar entries found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $entries->links('pagination::default') }}

@endsection
