@extends('layouts.app')

@section('title', 'Regional Offices | Department of Land Title Settlement')

@section('content')

    {{-- Banner --}}
    @include('partials.page-banner', [
        'title' => 'Regional Offices',
        'subtitle' => 'Find contact details for Land Title Settlement offices across all 25 districts',
        'parent' => 'Contact Us',
        'parentUrl' => route('contact.inquiry'),
        'showContactnav' => true
    ])

    <div class="contact-page-content">
        <div class="container">

            {{-- Section Label --}}
            <div class="section-intro-text text-center reveal" style="margin-bottom:2.5rem;">
                <span class="section-label">Island-Wide Network</span>
                <h2 class="section-title">District Office Directory</h2>
                <p class="section-subtitle">All regional offices grouped by province for easy navigation</p>
            </div>

            {{-- Search / Filter Bar --}}
            <div class="ro-filter-bar reveal">
                <div class="ro-search-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        style="width:18px;height:18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" id="ro-search" placeholder="Search by district, province, or address…"
                        autocomplete="off">
                </div>
                <div class="ro-count-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        style="width:16px;height:16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    </svg>
                    <span><strong>{{ count($districts) }}</strong> Offices across <strong>9</strong> Provinces</span>
                </div>
            </div>

            {{-- Grouped by Province --}}
            @php
                $grouped = collect($districts)->groupBy('province');
            @endphp

            @foreach($grouped as $province => $offices)
                <div class="ro-province-section reveal" data-province="{{ $province }}">
                    <div class="ro-province-header">
                        <div class="ro-province-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                style="width:22px;height:22px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                            </svg>
                        </div>
                        <div>
                            <h3>{{ $province }}</h3>
                            <span class="ro-province-count">{{ count($offices) }}
                                {{ count($offices) === 1 ? 'Office' : 'Offices' }}</span>
                        </div>
                    </div>

                    <div class="ro-offices-grid">
                        @foreach($offices as $office)
                            <div class="ro-office-card"
                                data-search="{{ strtolower($office['office'] . ' ' . $province . ' ' . $office['address']) }}">
                                <div class="ro-office-card-top"></div>
                                <div class="ro-office-card-body">
                                    <div class="ro-office-header">
                                        <div class="ro-office-pin">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" style="width:20px;height:20px;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <h4>{{ $office['office'] }}</h4>
                                    </div>

                                    <div class="ro-office-details">
                                        {{-- Address --}}
                                        <div class="ro-detail-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                            <span>{{ $office['address'] }}</span>
                                        </div>

                                        {{-- Phone --}}
                                        <div class="ro-detail-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            <a href="tel:{{ $office['phone'] }}">{{ $office['phone'] }}</a>
                                        </div>

                                        {{-- Email --}}
                                        <div class="ro-detail-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <a href="mailto:{{ $office['email'] }}">{{ $office['email'] }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            {{-- No results message --}}
            <div class="ro-no-results" id="ro-no-results" style="display: none;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    style="width:48px;height:48px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h3>No offices found</h3>
                <p>Try a different search term or browse by province above.</p>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('ro-search');
                const noResults = document.getElementById('ro-no-results');

                if (searchInput) {
                    searchInput.addEventListener('input', function () {
                        const query = this.value.toLowerCase().trim();
                        const cards = document.querySelectorAll('.ro-office-card');
                        const provinceSections = document.querySelectorAll('.ro-province-section');
                        let totalVisible = 0;

                        provinceSections.forEach(section => {
                            const sectionCards = section.querySelectorAll('.ro-office-card');
                            let sectionVisible = 0;

                            sectionCards.forEach(card => {
                                const searchData = card.getAttribute('data-search');
                                if (!query || searchData.includes(query)) {
                                    card.style.display = '';
                                    sectionVisible++;
                                    totalVisible++;
                                } else {
                                    card.style.display = 'none';
                                }
                            });

                            section.style.display = sectionVisible > 0 ? '' : 'none';
                        });

                        noResults.style.display = totalVisible === 0 ? 'flex' : 'none';
                    });
                }
            });
        </script>
    @endpush

@endsection