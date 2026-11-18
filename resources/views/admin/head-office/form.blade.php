@extends('layouts.admin')

@section('title', $item->exists ? 'Edit Division' : 'Add Division')

@section('content')

    <a href="{{ route('admin.head-office.index') }}" class="back-link">&larr; Back to Head Office</a>

    <form method="POST"
        action="{{ $item->exists ? route('admin.head-office.update', $item) : route('admin.head-office.store') }}"
        class="panel form-panel" novalidate>
        @csrf
        @if($item->exists)
            @method('PUT')
        @endif

        <div class="form-row">
            <div class="form-group">
                <label for="division">Division / Section <span class="hint">(English)</span></label>
                <input type="text" id="division" name="division" value="{{ old('division', $item->division) }}"
                    maxlength="255" placeholder="e.g. Land Division"
                    class="form-input @error('division') is-invalid @enderror">
                @error('division') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="position">Position <span class="hint">(English – optional; if added, add it in Sinhala and Tamil too)</span></label>
                <input type="text" id="position" name="position" value="{{ old('position', $item->position) }}"
                    maxlength="255" placeholder="e.g. Deputy Commissioner (Land)"
                    class="form-input @error('position') is-invalid @enderror">
                @error('position') <small class="form-error">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="officer">Officer name <span class="hint">(optional)</span></label>
            <input type="text" id="officer" name="officer" value="{{ old('officer', $item->officer) }}" maxlength="255"
                placeholder="e.g. Mrs. S. M. Jayawardena" class="form-input @error('officer') is-invalid @enderror">
            @error('officer') <small class="form-error">{{ $message }}</small> @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $item->phone) }}" maxlength="50"
                    placeholder="011-2888936" class="form-input @error('phone') is-invalid @enderror">
                @error('phone') <small class="form-error">{{ $message }}</small> @enderror
            </div>
            <div class="form-group">
                <label for="fax">Fax</label>
                <input type="text" id="fax" name="fax" value="{{ old('fax', $item->fax) }}" maxlength="50"
                    placeholder="011-2888937" class="form-input @error('fax') is-invalid @enderror">
                @error('fax') <small class="form-error">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="extension">Extension</label>
                <input type="text" id="extension" name="extension" value="{{ old('extension', $item->extension) }}"
                    maxlength="20" placeholder="110" class="form-input @error('extension') is-invalid @enderror">
                @error('extension') <small class="form-error">{{ $message }}</small> @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $item->email) }}" maxlength="255"
                    placeholder="land@landtitle.gov.lk" class="form-input @error('email') is-invalid @enderror">
                @error('email') <small class="form-error">{{ $message }}</small> @enderror
            </div>
        </div>

        {{-- Sinhala and Tamil versions – required, content is added in all 3 languages --}}
        @foreach(['si' => 'Sinhala (සිංහල)', 'ta' => 'Tamil (தமிழ்)'] as $lang => $languageName)
            <fieldset class="form-group faq-translation">
                <legend>{{ $languageName }} <span class="hint">(required)</span></legend>

                <div class="form-row">
                    <div class="form-group">
                        <label for="division_{{ $lang }}">Division / Section in {{ $languageName }}</label>
                        <input type="text" id="division_{{ $lang }}" name="division_{{ $lang }}" lang="{{ $lang }}"
                            value="{{ old("division_{$lang}", $item->{"division_{$lang}"}) }}" maxlength="255"
                            class="form-input @error("division_{$lang}") is-invalid @enderror">
                        @error("division_{$lang}") <small class="form-error">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="position_{{ $lang }}">Position in {{ $languageName }}</label>
                        <input type="text" id="position_{{ $lang }}" name="position_{{ $lang }}" lang="{{ $lang }}"
                            value="{{ old("position_{$lang}", $item->{"position_{$lang}"}) }}" maxlength="255"
                            class="form-input @error("position_{$lang}") is-invalid @enderror">
                        @error("position_{$lang}") <small class="form-error">{{ $message }}</small> @enderror
                    </div>
                </div>
            </fieldset>
        @endforeach

        <div class="form-group form-narrow">
            <label for="sort_order">Display order <span class="hint">(lower numbers show first)</span></label>
            <input type="number" id="sort_order" name="sort_order" min="0"
                value="{{ old('sort_order', $item->sort_order) }}"
                class="form-input @error('sort_order') is-invalid @enderror">
            @error('sort_order') <small class="form-error">{{ $message }}</small> @enderror
        </div>

        <div class="form-checks">
            <label class="form-check">
                <input type="checkbox" name="is_published" value="1"
                    {{ old('is_published', $item->is_published) ? 'checked' : '' }}>
                <span><strong>Show on website</strong> – listed on Contact Us → Head Office (untick to hide it)</span>
            </label>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">{{ $item->exists ? 'Save Changes' : 'Add Division' }}</button>
            <a href="{{ route('admin.head-office.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </form>

@endsection
