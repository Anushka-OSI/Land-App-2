@extends('layouts.app')

@section('title', __('About Us | Department of Land Title Settlement | Sri Lanka'))

@section('content')

    {{-- Banner --}}
    @include('partials.page-banner', [
        'title' => __('About Us'),
        'subtitle' => __('Pioneering Transparent Land Settlement and Title Registration in Sri Lanka'),
        'showSubnav' => true
    ])

    <div class="about-page-content">
        <div class="container">

            {{-- Subcategories Hub Navigation Cards --}}
            <section class="about-hub-section reveal">
                <div class="section-intro-text text-center">
                    <span class="section-label">{{ __('Explore About Us') }}</span>
                    <h2 class="section-title">{{ __('Department Divisions & Mandate') }}</h2>
                    <p class="section-subtitle">{{ __('Select a category below or explore the full department overview') }}</p>
                </div>

                <div class="about-hub-grid">

                    {{-- Hub Card 1: Overview --}}
                    <a href="{{ route('about.overview') }}" class="about-hub-card" id="hub-card-overview">
                        <div class="hub-card-icon gold">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="hub-card-content">
                            <span class="hub-tag">{{ __('Subcategory 01') }}</span>
                            <h3 class="hub-title">{{ __('Overview') }}</h3>
                            <p class="hub-desc">{{ __('Our vision "A settled Title for every land", strategic mission, and 90+ years of institutional history.') }}</p>
                            <span class="hub-link-text">
                                {{ __('Read Overview') }}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </div>
                    </a>

                    {{-- Hub Card 2: Organization Charts --}}
                    <a href="{{ route('about.organization-chart') }}" class="about-hub-card" id="hub-card-org">
                        <div class="hub-card-icon green">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                        </div>
                        <div class="hub-card-content">
                            <span class="hub-tag">{{ __('Subcategory 02') }}</span>
                            <h3 class="hub-title">{{ __('Organization Charts') }}</h3>
                            <p class="hub-desc">{{ __('Interactive organizational hierarchy, Commissioner divisions, legal officers, and 18 provincial offices.') }}</p>
                            <span class="hub-link-text">
                                {{ __('View Structure') }}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </div>
                    </a>

                    {{-- Hub Card 3: Aims & Objectives --}}
                    <a href="{{ route('about.aims') }}" class="about-hub-card" id="hub-card-aims">
                        <div class="hub-card-icon teal">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="hub-card-content">
                            <span class="hub-tag">{{ __('Subcategory 03') }}</span>
                            <h3 class="hub-title">{{ __('Our Aims & Objectives') }}</h3>
                            <p class="hub-desc">{{ __('The 7 core statutory aims defining land ownership determinations, title registrations, and public trust.') }}</p>
                            <span class="hub-link-text">
                                {{ __('Explore Aims') }}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </div>
                    </a>

                </div>
            </section>

            {{-- Vision & Mission Highlight Section --}}
            <section class="about-hero-cards reveal">
                <div class="about-card-grid">

                    {{-- Vision Card --}}
                    <div class="about-feature-card vision-card">
                        <div class="feature-card-header">
                            <div class="feature-icon-badge gold">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </div>
                            <span class="feature-pill gold">{{ __('Our Vision') }}</span>
                        </div>
                        <blockquote class="feature-quote">
                            {{ __('"A settled Title for every land"') }}
                        </blockquote>
                        <p class="feature-card-desc">
                            {{ __('Ensuring that every land parcel across Sri Lanka carries a certified, legally recognized, and unambiguous title of ownership.') }}
                        </p>
                    </div>

                    {{-- Mission Card --}}
                    <div class="about-feature-card mission-card">
                        <div class="feature-card-header">
                            <div class="feature-icon-badge green">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <span class="feature-pill green">{{ __('Our Mission') }}</span>
                        </div>
                        <p class="feature-body-lead">
                            {{ __('To contribute to establish an improved Land Management System in Sri Lanka through the process of Land Settlement and Title Registration that determines the ownership of state owned and private lands and confirm the title of every land parcel.') }}
                        </p>
                    </div>

                </div>
            </section>

            {{-- Organization Structure Preview --}}
            <section class="about-org-preview-section reveal">
                <div class="org-preview-container">
                    <div class="org-preview-text">
                        <span class="section-label">{{ __('Institutional Structure') }}</span>
                        <h2 class="section-title">{{ __('Organization Chart') }}</h2>
                        <p class="section-subtitle">
                            {{ __('The Department is structured under the Commissioner of Title Settlement, supported by dedicated Commissioners for Lands, Bimsaviya, and Administration, spanning 18 Provincial Title Offices.') }}
                        </p>
                        <div class="org-preview-actions">
                            <a href="{{ route('about.organization-chart') }}" class="btn btn-primary">
                                {{ __('View Full Interactive Chart') }}
                            </a>
                            <a href="{{ asset('images/organization_structure.jpg') }}" download="Organization_Structure.jpg" class="btn btn-outline" style="color:var(--green-800);border-color:var(--green-700);">
                                {{ __('Download Chart Image') }}
                            </a>
                        </div>
                    </div>
                    <div class="org-preview-thumb">
                        <a href="{{ route('about.organization-chart') }}" class="thumb-link">
                            <img src="{{ asset('images/organization_structure.jpg') }}" alt="{{ __('Organization Structure Preview') }}" class="thumb-img">
                            <div class="thumb-overlay">
                                <span>{{ __('Click to View Full Interactive Chart') }}</span>
                            </div>
                        </a>
                    </div>
                </div>
            </section>

            {{-- 7 Aims Section --}}
            <section class="aims-full-grid reveal" style="margin-top: 4rem;">
                <div class="section-intro-text text-center" style="grid-column: 1 / -1; margin-bottom: 2rem;">
                    <span class="section-label">{{ __('Statutory Mandate') }}</span>
                    <h2 class="section-title">{{ __('Aims of the Organization') }}</h2>
                    <p class="section-subtitle">{{ __('Seven foundational objectives governing land settlement & registration in Sri Lanka') }}</p>
                </div>
                @foreach($aims as $aim)
                    <article class="aim-card-full" id="aim-hub-{{ $aim['id'] }}">
                        <div class="aim-card-header">
                            <span class="aim-number">0{{ $aim['id'] }}</span>
                            <span class="aim-act-badge">{{ $aim['act'] }}</span>
                        </div>
                        <div class="aim-card-body">
                            <h3 class="aim-card-title">{{ $aim['title'] }}</h3>
                            <p class="aim-card-desc">{{ $aim['description'] }}</p>
                        </div>
                    </article>
                @endforeach
            </section>

        </div>
    </div>

@endsection
