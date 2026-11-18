@extends('layouts.admin')

@section('title', $item->exists ? 'Edit Regional Office' : 'Add Regional Office')

@section('content')

    <a href="{{ route('admin.regional-offices.index') }}" class="back-link">&larr; Back to Regional Offices</a>

    <form method="POST"
        action="{{ $item->exists ? route('admin.regional-offices.update', $item) : route('admin.regional-offices.store') }}"
        class="panel form-panel" novalidate>
        @csrf
        @if($item->exists)
            @method('PUT')
        @endif

        <div class="form-row">
            <div class="form-group">
                <label for="name">Office name <span class="hint">(English)</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $item->name) }}" maxlength="255"
                    placeholder="e.g. Title Settlement Office – Kandy"
                    class="form-input @error('name') is-invalid @enderror">
                @error('name') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="province">Province</label>
                <select id="province" name="province" class="form-input @error('province') is-invalid @enderror">
                    @foreach(\App\Models\RegionalOffice::PROVINCES as $key => $label)
                        <option value="{{ $key }}" @selected(old('province', $item->province) === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('province') <small class="form-error">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="address">Address <span class="hint">(English – optional; if added, add it in Sinhala and Tamil too)</span></label>
            <input type="text" id="address" name="address" value="{{ old('address', $item->address) }}" maxlength="500"
                placeholder="e.g. No. 23, Peradeniya Road, Kandy"
                class="form-input @error('address') is-invalid @enderror">
            @error('address') <small class="form-error">{{ $message }}</small> @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $item->phone) }}" maxlength="50"
                    placeholder="081-2234567" class="form-input @error('phone') is-invalid @enderror">
                @error('phone') <small class="form-error">{{ $message }}</small> @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $item->email) }}" maxlength="255"
                    placeholder="kandy@landtitle.gov.lk" class="form-input @error('email') is-invalid @enderror">
                @error('email') <small class="form-error">{{ $message }}</small> @enderror
            </div>
        </div>

        {{-- Location on the website maps --}}
        @include('admin.partials.location-picker', ['lat' => $item->latitude, 'lng' => $item->longitude, 'addressField' => 'address'])

        {{-- Sinhala and Tamil versions – required, content is added in all 3 languages --}}
        @foreach(['si' => 'Sinhala (සිංහල)', 'ta' => 'Tamil (தமிழ்)'] as $lang => $languageName)
            <fieldset class="form-group faq-translation">
                <legend>{{ $languageName }} <span class="hint">(required)</span></legend>

                <div class="form-group">
                    <label for="name_{{ $lang }}">Office name in {{ $languageName }}</label>
                    <input type="text" id="name_{{ $lang }}" name="name_{{ $lang }}" lang="{{ $lang }}"
                        value="{{ old("name_{$lang}", $item->{"name_{$lang}"}) }}" maxlength="255"
                        class="form-input @error("name_{$lang}") is-invalid @enderror">
                    @error("name_{$lang}") <small class="form-error">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label for="address_{{ $lang }}">Address in {{ $languageName }}</label>
                    <input type="text" id="address_{{ $lang }}" name="address_{{ $lang }}" lang="{{ $lang }}"
                        value="{{ old("address_{$lang}", $item->{"address_{$lang}"}) }}" maxlength="500"
                        class="form-input @error("address_{$lang}") is-invalid @enderror">
                    @error("address_{$lang}") <small class="form-error">{{ $message }}</small> @enderror
                </div>
            </fieldset>
        @endforeach

        <div class="form-group form-narrow">
            <label for="sort_order">Display order <span class="hint">(within its province – lower numbers show first)</span></label>
            <input type="number" id="sort_order" name="sort_order" min="0"
                value="{{ old('sort_order', $item->sort_order) }}"
                class="form-input @error('sort_order') is-invalid @enderror">
            @error('sort_order') <small class="form-error">{{ $message }}</small> @enderror
        </div>

        <div class="form-checks">
            <label class="form-check">
                <input type="checkbox" name="is_published" value="1"
                    {{ old('is_published', $item->is_published) ? 'checked' : '' }}>
                <span><strong>Show on website</strong> – listed on Contact Us → Regional Offices (untick to hide it)</span>
            </label>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">{{ $item->exists ? 'Save Changes' : 'Add Office' }}</button>
            <a href="{{ route('admin.regional-offices.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </form>

@endsection
