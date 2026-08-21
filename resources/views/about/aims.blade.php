@extends('layouts.app')

@section('title', 'Aims & Objectives | About Us | Department of Land Title Settlement')

@section('content')

    {{-- Banner --}}
    @include('partials.page-banner', [
        'title' => 'Our Aims & Objectives',
        'subtitle' => 'Statutory Responsibilities, Operational Mandate, and Strategic Goals',
        'parent' => 'About Us',
        'parentUrl' => route('about'),
        'showSubnav' => true
    ])

    <div class="about-page-content">
        <div class="container">

            {{-- Section Intro --}}
            <div class="section-intro-text text-center reveal">
                <span class="section-label">Statutory Mandate</span>
                <h2 class="section-title">Aims of the Organization</h2>
                <p class="section-subtitle">Core institutional goals under Sri Lankan legislation governing land settlement and title registration</p>
            </div>

            {{-- Comprehensive 7 Aims Grid --}}
            <section class="aims-full-grid">
                @foreach($aims as $aim)
                    <article class="aim-card-full reveal" id="aim-{{ $aim['id'] }}">
                        <div class="aim-card-header">
                            <span class="aim-number">0{{ $aim['id'] }}</span>
                            <span class="aim-act-badge">{{ $aim['act'] }}</span>
                        </div>
                        <div class="aim-card-body">
                            <h3 class="aim-card-title">{{ $aim['title'] }}</h3>
                            <p class="aim-card-desc">{{ $aim['description'] }}</p>
                        </div>
                        <div class="aim-card-footer">
                            <div class="aim-indicator">
                                <span class="indicator-dot"></span>
                                <span>Statutory Obligation</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </section>

            {{-- Legal Acts Callout Banner --}}
            <section class="acts-callout-section reveal">
                <div class="acts-callout-box">
                    <div class="acts-callout-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <div class="acts-callout-text">
                        <h3>Key Legislative Framework</h3>
                        <p>
                            All functions and powers executed by the Department of Land Title Settlement are codified under the <strong>Land Settlement Ordinance No. 20 of 1931</strong> and the <strong>Registration of Title Act No. 21 of 1998</strong>.
                        </p>
                    </div>
                    <a href="{{ route('about.overview') }}" class="btn btn-outline" style="border-color:rgba(255,255,255,0.4);color:white;white-space:nowrap;">
                        Read Overview
                    </a>
                </div>
            </section>

        </div>
    </div>

@endsection
