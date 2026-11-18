@extends('layouts.app')

@section('title', __('Head Office Directory | Department of Land Title Settlement'))

@section('content')

    {{-- Banner --}}
    @include('partials.page-banner', [
        'title' => __('Head Office Directory'),
        'subtitle' => __('Contact details for all divisions at the Battaramulla headquarters'),
        'parent' => __('Contact Us'),
        'parentUrl' => route('contact.inquiry'),
        'showContactnav' => true
    ])

    <div class="contact-page-content">
        <div class="container">

            {{-- Head Office Address Card (Admin → Head Office → Office details) --}}
            @if($headOffice['name'] || $headOffice['address'] || $headOffice['phone'] || $headOffice['fax'] || $headOffice['email'])
            <div class="ho-address-strip reveal" id="head-office">
                <div class="ho-addr-card">
                    <div class="ho-addr-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            style="width:28px;height:28px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div class="ho-addr-details">
                        @if($headOffice['name'])
                            <h3>{{ $headOffice['name'] }}</h3>
                        @endif
                        @if($headOffice['address'])
                            <p>{{ $headOffice['address'] }}</p>
                        @endif
                    </div>
                    <div class="ho-addr-contact">
                        @if($headOffice['phone'])
                            <span><strong>{{ __('General') }}:</strong> <a href="tel:{{ $headOffice['phone'] }}">{{ $headOffice['phone'] }}</a></span>
                        @endif
                        @if($headOffice['fax'])
                            <span><strong>{{ __('Fax') }}:</strong> {{ $headOffice['fax'] }}</span>
                        @endif
                        @if($headOffice['email'])
                            <span><strong>{{ __('Email') }}:</strong> <a href="mailto:{{ $headOffice['email'] }}">{{ $headOffice['email'] }}</a></span>
                        @endif
                    </div>
                </div>

                {{-- Location (Admin → Head Office → Office details) --}}
                @if($headOffice['location'])
                    @include('partials.leaflet')
                    <div class="office-location office-location--wide">
                        <div class="office-location-map" data-location-map
                            data-lat="{{ $headOffice['location'][0] }}" data-lng="{{ $headOffice['location'][1] }}" data-zoom="16"
                            data-name="{{ $headOffice['name'] }}" role="region" aria-label="{{ __('Map: :name', ['name' => $headOffice['name']]) }}"></div>
                        <a class="office-directions" target="_blank" rel="noopener"
                            href="{{ \App\Support\OfficeLocations::directionsUrl($headOffice['location'][0], $headOffice['location'][1]) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                            {{ __('Get directions') }}
                        </a>
                    </div>
                @endif
            </div>
            @endif

            {{-- Section Label --}}
            <div class="section-intro-text text-center reveal" style="margin-bottom:2.5rem;">
                <span class="section-label">{{ __('Divisions & Officers') }}</span>
                <h2 class="section-title">{{ __('Head Office Directory') }}</h2>
                <p class="section-subtitle">{{ __('Complete contact information for all divisions and sections') }}</p>
            </div>

            @if(count($divisions))
            {{-- Division Table --}}
            <div class="ho-table-wrap reveal">
                <div class="ho-table-toolbar">
                    <div class="ho-table-toolbar-info">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            style="width:18px;height:18px;color:var(--gold-400);">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0" />
                        </svg>
                        <span>{{ __(':count Divisions & Sections', ['count' => count($divisions)]) }}</span>
                    </div>
                    <div class="ho-table-search">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            style="width:16px;height:16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" id="ho-search" placeholder="{{ __('Search divisions…') }}" autocomplete="off">
                    </div>
                </div>

                <div class="ho-table-container">
                    <table class="ho-table" id="ho-directory-table">
                        <thead>
                            <tr>
                                <th>{{ __('Division / Section') }}</th>
                                <th>{{ __('Position') }}</th>
                                <th>{{ __('Officer Name') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('Fax') }}</th>
                                <th>{{ __('Ext.') }}</th>
                                <th>{{ __('Email') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($divisions as $index => $div)
                                <tr>
                                    <td>
                                        <div class="ho-division-name">
                                            <span class="ho-div-dot"
                                                style="background: {{ $index === 0 ? 'var(--gold-500)' : 'var(--green-500)' }};"></span>
                                            <strong>{{ $div['division'] }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $div['position'] }}</td>
                                    <td><span class="ho-officer-name">{{ $div['officer'] }}</span></td>
                                    <td><a href="tel:{{ $div['phone'] }}" class="ho-phone-link">{{ $div['phone'] }}</a></td>
                                    <td>{{ $div['fax'] }}</td>
                                    <td><span class="ho-ext-badge">{{ $div['extension'] }}</span></td>
                                    <td><a href="mailto:{{ $div['email'] }}" class="ho-email-link">{{ $div['email'] }}</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($headOffice['hours'])
                <div class="ho-table-footer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        style="width:14px;height:14px; color:var(--green-600);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ __('Office hours') }}: {{ $headOffice['hours'] }}</span>
                </div>
                @endif
            </div>

            {{-- Division Cards (Mobile-friendly) --}}
            <div class="ho-cards-grid">
                @foreach($divisions as $index => $div)
                    <div class="ho-card reveal" style="animation-delay: {{ $index * 0.05 }}s;">
                        <div class="ho-card-top"
                            style="background: linear-gradient(90deg, {{ $index === 0 ? 'var(--gold-500), var(--gold-600)' : 'var(--green-600), var(--green-400)' }});">
                        </div>
                        <div class="ho-card-body">
                            <div class="ho-card-header">
                                <span class="ho-card-badge">{{ $index === 0 ? __('★ Head') : __('Division') }}</span>
                                <h4>{{ $div['division'] }}</h4>
                            </div>
                            <div class="ho-card-officer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    style="width:16px;height:16px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <div>
                                    <span class="ho-card-pos">{{ $div['position'] }}</span>
                                    <span class="ho-card-name">{{ $div['officer'] }}</span>
                                </div>
                            </div>
                            <div class="ho-card-contacts">
                                <div class="ho-card-contact-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" style="width:14px;height:14px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <a href="tel:{{ $div['phone'] }}">{{ $div['phone'] }}</a>
                                </div>
                                <div class="ho-card-contact-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" style="width:14px;height:14px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span>{{ __('Fax') }}: {{ $div['fax'] }}</span>
                                </div>
                                <div class="ho-card-contact-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" style="width:14px;height:14px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                    </svg>
                                    <span>{{ __('Ext') }}: {{ $div['extension'] }}</span>
                                </div>
                                <div class="ho-card-contact-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" style="width:14px;height:14px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <a href="mailto:{{ $div['email'] }}">{{ $div['email'] }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @else
                {{-- No divisions added yet (Admin → Head Office) --}}
                <div class="ro-no-results" style="display:block;">
                    <h3>{{ __('The Head Office directory will be available soon.') }}</h3>
                </div>
            @endif

        </div>
    </div>

    @push('scripts')
        <script>
            // Search functionality for head office table
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('ho-search');
                if (searchInput) {
                    searchInput.addEventListener('input', function () {
                        const query = this.value.toLowerCase();
                        const rows = document.querySelectorAll('#ho-directory-table tbody tr');
                        rows.forEach(row => {
                            const text = row.textContent.toLowerCase();
                            row.style.display = text.includes(query) ? '' : 'none';
                        });
                    });
                }
            });
        </script>
    @endpush

@endsection