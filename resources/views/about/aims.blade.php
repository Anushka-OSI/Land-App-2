@extends('layouts.app')

@section('title', __('Aims & Objectives | About Us | Department of Land Title Settlement'))

@section('content')

    {{-- Banner --}}
    @include('partials.page-banner', [
        'title' => __('Our Aims & Objectives'),
        'subtitle' => __('Statutory Responsibilities, Operational Mandate, and Strategic Goals'),
        'parent' => __('About Us'),
        'parentUrl' => route('about'),
        'showSubnav' => true
    ])

    <div class="about-page-content">
        <div class="container">

            {{-- Section Intro --}}
            <div class="section-intro-text text-center reveal">
                <span class="section-label">{{ __('Statutory Mandate') }}</span>
                <h2 class="section-title">{{ __('Aims of the Organization') }}</h2>
                <p class="section-subtitle">{{ __('Core institutional goals under Sri Lankan legislation governing land settlement and title registration') }}</p>
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
                                <span>{{ __('Statutory Obligation') }}</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </section>

        </div>
    </div>

@endsection
