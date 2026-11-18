@extends('layouts.admin')

@section('title', 'Head Office Details')

@section('content')

    <a href="{{ route('admin.head-office.index') }}" class="back-link">&larr; Back to Head Office</a>

    <form method="POST" action="{{ route('admin.head-office-details.update') }}" class="panel form-panel" novalidate>
        @csrf
        @method('PUT')

        <p class="page-help">Shown in the address box on <strong>Contact Us → Head Office</strong> and in the contact
            boxes on <strong>Contact Us → Inquiry</strong>. Anything left empty is not shown. The map location is
            shown on the Head Office page and on the homepage office map.</p>

        <div class="form-row">
            <div class="form-group">
                <label for="phone">General phone</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $details['phone']) }}" maxlength="50"
                    placeholder="e.g. 011-2888935" class="form-input @error('phone') is-invalid @enderror">
                @error('phone') <small class="form-error">{{ $message }}</small> @enderror
            </div>
            <div class="form-group">
                <label for="fax">Fax</label>
                <input type="text" id="fax" name="fax" value="{{ old('fax', $details['fax']) }}" maxlength="50"
                    placeholder="e.g. 011-2888937" class="form-input @error('fax') is-invalid @enderror">
                @error('fax') <small class="form-error">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="email">General email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $details['email']) }}" maxlength="255"
                placeholder="e.g. info@landtitle.gov.lk" class="form-input @error('email') is-invalid @enderror">
            @error('email') <small class="form-error">{{ $message }}</small> @enderror
        </div>

        @foreach(\App\Support\Languages::ALL as $lang => $info)
            @php $languageName = $info['native'] === $info['label'] ? $info['label'] : "{$info['label']} ({$info['native']})"; @endphp
            <fieldset class="form-group faq-translation">
                <legend>{{ $languageName }} <span class="hint">(required)</span></legend>

                <div class="form-group">
                    <label for="name_{{ $lang }}">Office name in {{ $info['label'] }}</label>
                    <input type="text" id="name_{{ $lang }}" name="name_{{ $lang }}" lang="{{ $lang }}" maxlength="255"
                        value="{{ old("name_{$lang}", $details["name_{$lang}"]) }}"
                        @if($lang === 'en') placeholder="e.g. Department of Land Title Settlement – Head Office" @endif
                        class="form-input @error("name_{$lang}") is-invalid @enderror">
                    @error("name_{$lang}") <small class="form-error">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="address_{{ $lang }}">Address in {{ $info['label'] }}</label>
                    <textarea id="address_{{ $lang }}" name="address_{{ $lang }}" lang="{{ $lang }}" rows="2" maxlength="500"
                        @if($lang === 'en') placeholder="e.g. No. 1200/6, &quot;Mihikatha Medura&quot;, Rajamalwatta Road, Battaramulla" @endif
                        class="form-input @error("address_{$lang}") is-invalid @enderror">{{ old("address_{$lang}", $details["address_{$lang}"]) }}</textarea>
                    @error("address_{$lang}") <small class="form-error">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="hours_{{ $lang }}">Office hours in {{ $info['label'] }} <span class="hint">(optional – if
                            added, add it in all 3 languages)</span></label>
                    <input type="text" id="hours_{{ $lang }}" name="hours_{{ $lang }}" lang="{{ $lang }}" maxlength="500"
                        value="{{ old("hours_{$lang}", $details["hours_{$lang}"]) }}"
                        @if($lang === 'en') placeholder="e.g. Monday – Friday, 8:30 AM – 4:15 PM" @endif
                        class="form-input @error("hours_{$lang}") is-invalid @enderror">
                    @error("hours_{$lang}") <small class="form-error">{{ $message }}</small> @enderror
                </div>
            </fieldset>
        @endforeach

        {{-- Location on the website maps --}}
        @include('admin.partials.location-picker', ['lat' => $details['latitude'], 'lng' => $details['longitude'], 'addressField' => 'address_en'])

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Details</button>
            <a href="{{ route('admin.head-office.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </form>

@endsection
