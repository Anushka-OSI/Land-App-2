@extends('layouts.admin')

@php
    $types = [
        'event' => ['Department Event', 'A meeting, mobile service, ceremony or other event of the department.'],
        'special_holiday' => ['Special Holiday', 'An extra holiday for the department (e.g. a special Government holiday not yet in the public calendar).'],
        'working_day' => ['Special Working Day', 'The department is open on this day although it is a weekend or holiday.'],
    ];
    $currentType = old('type', $entry->type);
    $heading = $entry->exists ? 'Edit ' . $types[$entry->type][0] : 'Add ' . ($types[$currentType][0] ?? 'Calendar Entry');
@endphp

@section('title', $heading)

@section('content')

    <a href="{{ route('admin.calendar.index') }}" class="back-link">&larr; Back to Event Calendar</a>

    <form method="POST" action="{{ $entry->exists ? route('admin.calendar.update', $entry) : route('admin.calendar.store') }}"
        class="panel form-panel" novalidate>
        @csrf
        @if($entry->exists)
            @method('PUT')
        @endif

        <fieldset class="form-group">
            <legend class="form-legend">Type</legend>
            <div class="cal-type-options">
                @foreach($types as $value => [$label, $help])
                    <label class="cal-type-option">
                        <input type="radio" name="type" value="{{ $value }}" @checked($currentType === $value)>
                        <span>
                            <strong>{{ $label }}</strong>
                            <small>{{ $help }}</small>
                        </span>
                    </label>
                @endforeach
            </div>
            @error('type') <small class="form-error">{{ $message }}</small> @enderror
        </fieldset>

        <div class="form-row">
            <div class="form-group">
                <label for="start_date">Date</label>
                <input type="date" id="start_date" name="start_date"
                    value="{{ old('start_date', $entry->start_date?->toDateString()) }}"
                    class="form-input @error('start_date') is-invalid @enderror">
                @error('start_date') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="end_date">End date <span class="hint">(optional – only for entries longer than one day)</span></label>
                <input type="date" id="end_date" name="end_date"
                    value="{{ old('end_date', $entry->end_date?->toDateString()) }}"
                    class="form-input @error('end_date') is-invalid @enderror">
                @error('end_date') <small class="form-error">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="form-group" data-event-only>
            <label for="start_time">Start time <span class="hint">(optional)</span></label>
            <input type="time" id="start_time" name="start_time"
                value="{{ old('start_time', $entry->start_time ? substr($entry->start_time, 0, 5) : '') }}"
                class="form-input cal-time-input @error('start_time') is-invalid @enderror">
            @error('start_time') <small class="form-error">{{ $message }}</small> @enderror
        </div>

        {{-- Title and description in all three languages --}}
        @foreach(\App\Support\Languages::ALL as $lang => $info)
            @php $languageName = $info['native'] === $info['label'] ? $info['label'] : "{$info['label']} ({$info['native']})"; @endphp
            <fieldset class="form-group faq-translation">
                <legend>{{ $languageName }} <span class="hint">(required)</span></legend>

                <div class="form-group">
                    <label for="title_{{ $lang }}">Title in {{ $info['label'] }}</label>
                    <input type="text" id="title_{{ $lang }}" name="title_{{ $lang }}" lang="{{ $lang }}"
                        value="{{ old("title_{$lang}", $entry->{"title_{$lang}"}) }}" maxlength="255"
                        class="form-input @error("title_{$lang}") is-invalid @enderror">
                    @error("title_{$lang}") <small class="form-error">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="description_{{ $lang }}">Description in {{ $info['label'] }}
                        <span class="hint">(optional – venue, who should attend, etc. If added, add it in all 3 languages)</span></label>
                    <textarea id="description_{{ $lang }}" name="description_{{ $lang }}" rows="3" lang="{{ $lang }}" maxlength="2000"
                        class="form-input @error("description_{$lang}") is-invalid @enderror">{{ old("description_{$lang}", $entry->{"description_{$lang}"}) }}</textarea>
                    @error("description_{$lang}") <small class="form-error">{{ $message }}</small> @enderror
                </div>
            </fieldset>
        @endforeach

        <div class="form-checks">
            <label class="form-check">
                <input type="checkbox" name="is_published" value="1"
                    {{ old('is_published', $entry->is_published) ? 'checked' : '' }}>
                <span><strong>Show on the website</strong> – untick to keep it hidden for now</span>
            </label>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">{{ $entry->exists ? 'Save Changes' : 'Add to Calendar' }}</button>
            <a href="{{ route('admin.calendar.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </form>

@endsection

@push('scripts')
    <script>
        // The start time is only used for department events
        (() => {
            const timeGroup = document.querySelector('[data-event-only]');
            const update = () => {
                const type = document.querySelector('input[name="type"]:checked')?.value;
                timeGroup.hidden = type !== 'event';
            };
            document.querySelectorAll('input[name="type"]').forEach((radio) => radio.addEventListener('change', update));
            update();
        })();
    </script>
@endpush
