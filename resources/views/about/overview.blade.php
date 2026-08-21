@extends('layouts.app')

@section('title', 'Overview | About Us | Department of Land Title Settlement')

@section('content')

    {{-- Banner --}}
    @include('partials.page-banner', [
        'title' => 'Overview',
        'subtitle' => 'Our Vision, Mission, and Statutory Mandate for Land Administration in Sri Lanka',
        'parent' => 'About Us',
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
                            <span class="feature-pill gold">Our Vision</span>
                        </div>
                        <blockquote class="feature-quote">
                            "A settled Title for every land"
                        </blockquote>
                        <p class="feature-card-desc">
                            Ensuring that every land parcel across Sri Lanka carries a certified, legally recognized, and unambiguous title of ownership to protect property rights for all generations.
                        </p>
                        <div class="card-footer-tag">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            National Strategic Priority
                        </div>
                    </div>

                    {{-- Mission Card --}}
                    <div class="about-feature-card mission-card reveal-right">
                        <div class="feature-card-header">
                            <div class="feature-icon-badge green">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <span class="feature-pill green">Our Mission</span>
                        </div>
                        <p class="feature-body-lead">
                            To contribute to establish an improved Land Management System in Sri Lanka through the process of Land Settlement and Title Registration that determines the ownership of state owned and private lands and confirm the title of every land parcel.
                        </p>
                        <div class="mission-checklist">
                            <div class="checklist-item">
                                <span class="check-dot"></span>
                                <span>Distinguish state-owned vs. private lands with absolute clarity</span>
                            </div>
                            <div class="checklist-item">
                                <span class="check-dot"></span>
                                <span>Execute systematic registration of titles under Act No. 21 of 1998</span>
                            </div>
                            <div class="checklist-item">
                                <span class="check-dot"></span>
                                <span>Deliver transparent and accessible land management services</span>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            {{-- Overview Narrative / Department Story --}}
            <section class="about-narrative-section reveal">
                <div class="narrative-box">
                    <div class="narrative-header">
                        <span class="section-label">Department Background</span>
                        <h2 class="section-title">Safeguarding Land Ownership Since 1931</h2>
                    </div>
                    <div class="narrative-body">
                        <p>
                            The <strong>Department of Land Title Settlement</strong> is the principal government institution tasked with defining, investigating, and confirming ownership rights across all state and private lands in the Democratic Socialist Republic of Sri Lanka.
                        </p>
                        <p>
                            Operating under the mandate of the <strong>Land Settlement Ordinance No. 20 of 1931</strong> and the <strong>Registration of Title Act No. 21 of 1998 (Bimsaviya)</strong>, the Department works continuously through its head office in Battaramulla and 18 regional title investigation offices across the island to ensure seamless land governance and public title security.
                        </p>
                    </div>
                </div>
            </section>

            {{-- Core Aims Summary on Overview Page --}}
            <section class="overview-aims-preview reveal">
                <div class="section-header-row">
                    <div>
                        <span class="section-label">Our Core Objectives</span>
                        <h2 class="section-title">Aims of the Organization</h2>
                    </div>
                    <a href="{{ route('about.aims') }}" class="btn-link-action">
                        View All Statutory Aims
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                <div class="aims-grid-preview">
                    @foreach(array_slice($aims, 0, 4) as $aim)
                        <div class="aim-mini-card">
                            <div class="aim-mini-num">0{{ $aim['id'] }}</div>
                            <h3 class="aim-mini-title">{{ $aim['title'] }}</h3>
                            <p class="aim-mini-desc">{{ Str::limit($aim['description'], 140) }}</p>
                            <span class="aim-mini-act">{{ $aim['act'] }}</span>
                        </div>
                    @endforeach
                </div>
            </section>

        </div>
    </div>

@endsection
