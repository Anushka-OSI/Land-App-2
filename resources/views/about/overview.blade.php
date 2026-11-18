@extends('layouts.app')

@section('title', __('Overview | About Us | Department of Land Title Settlement'))

@section('content')

    {{-- Banner --}}
    @include('partials.page-banner', [
        'title' => __('Overview'),
        'subtitle' => __('Our Vision, Mission, and Statutory Mandate for Land Administration in Sri Lanka'),
        'parent' => __('About Us'),
        'parentUrl' => route('about'),
        'showSubnav' => true
    ])

    <div class="about-page-content">
        <div class="container">

            {{-- Vision & Mission Highlight Section --}}
            <section class="about-hero-cards">
                <div class="about-card-grid">

                    {{-- Vision Card --}}
                    <div class="about-feature-card vision-card reveal-left">
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
                            {{ __('Ensuring that every land parcel across Sri Lanka carries a certified, legally recognized, and unambiguous title of ownership to protect property rights for all generations.') }}
                        </p>
                        <div class="card-footer-tag">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ __('National Strategic Priority') }}
                        </div>
                    </div>

                    {{-- Mission Card --}}
                    <div class="about-feature-card mission-card reveal-right">
                        <div class="feature-card-header">
                            <div class="feature-icon-badge green">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <span class="feature-pill green">{{ __('Our Mission') }}</span>
                        </div>
                        <p class="feature-body-lead">
                            {{ __('To contribute to establish an improved Land Management System in Sri Lanka through the process of Land Settlement and Title Registration that determines the ownership of state owned and private lands and confirm the title of every land parcel.') }}
                        </p>
                        <div class="mission-checklist">
                            <div class="checklist-item">
                                <span class="check-dot"></span>
                                <span>{{ __('Distinguish state-owned vs. private lands with absolute clarity') }}</span>
                            </div>
                            <div class="checklist-item">
                                <span class="check-dot"></span>
                                <span>{{ __('Execute systematic registration of titles under Act No. 21 of 1998') }}</span>
                            </div>
                            <div class="checklist-item">
                                <span class="check-dot"></span>
                                <span>{{ __('Deliver transparent and accessible land management services') }}</span>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            {{-- Overview Narrative / Department Story --}}
            <section class="about-narrative-section reveal">
                <div class="narrative-box">
                    <div class="narrative-header">
                        <span class="section-label">{{ __('Department Background') }}</span>
                        <h2 class="section-title">{{ __('Safeguarding Land Ownership Since 1931') }}</h2>
                    </div>
                    <div class="narrative-body">
                        <p>
                            {!! __('The <strong>Department of Land Title Settlement</strong> is the principal government institution tasked with defining, investigating, and confirming ownership rights across all state and private lands in the Democratic Socialist Republic of Sri Lanka.') !!}
                        </p>
                        <p>
                            {!! __('Operating under the mandate of the <strong>Land Settlement Ordinance No. 20 of 1931</strong> and the <strong>Registration of Title Act No. 21 of 1998 (Bimsaviya)</strong>, the Department works continuously through its head office in Battaramulla and 18 regional title investigation offices across the island to ensure seamless land governance and public title security.') !!}
                        </p>
                    </div>
                </div>
            </section>

            {{-- Key Legislative Framework --}}
            <section class="acts-callout-section reveal">
                <div class="acts-callout-box">
                    <div class="acts-callout-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <div class="acts-callout-text">
                        <h3>{{ __('Key Legislative Framework') }}</h3>
                        <p>
                            {!! __('All functions and powers executed by the Department of Land Title Settlement are codified under the <strong>Land Settlement Ordinance No. 20 of 1931</strong> and the <strong>Registration of Title Act No. 21 of 1998</strong>.') !!}
                        </p>
                    </div>
                    <a href="{{ route('about.aims') }}" class="btn btn-outline" style="border-color:rgba(255,255,255,0.4);color:white;white-space:nowrap;">
                        {{ __('Our Aims & Objectives') }}
                    </a>
                </div>
            </section>

        </div>
    </div>

@endsection
