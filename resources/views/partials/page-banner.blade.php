{{-- Inner Page Hero Banner --}}
<section class="page-banner" aria-label="{{ $title ?? 'Page Banner' }}">
    <div class="page-banner-bg" aria-hidden="true"></div>
    <div class="page-banner-overlay" aria-hidden="true"></div>
    <div class="container">
        <div class="page-banner-content">
            <nav class="breadcrumbs" aria-label="Breadcrumb navigation">
                <a href="{{ route('home') }}">Home</a>
                <span class="crumb-separator">/</span>
                @if(isset($parent) && isset($parentUrl))
                    <a href="{{ $parentUrl }}">{{ $parent }}</a>
                    <span class="crumb-separator">/</span>
                @endif
                <span class="crumb-current">{{ $title ?? 'About Us' }}</span>
            </nav>
            <h1 class="page-banner-title">{{ $title ?? 'About Us' }}</h1>
            @if(isset($subtitle))
                <p class="page-banner-subtitle">{{ $subtitle }}</p>
            @endif

            {{-- Sub-category Navigation Tabs --}}
            @if(isset($showSubnav) && $showSubnav)
                <div class="about-subnav" role="tablist" aria-label="About Us subcategories">
                    <a href="{{ route('about.overview') }}" class="subnav-pill {{ request()->routeIs('about.overview') || request()->routeIs('about') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Overview
                    </a>
                    <a href="{{ route('about.organization-chart') }}" class="subnav-pill {{ request()->routeIs('about.organization-chart') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                        Organization Chart
                    </a>
                    <a href="{{ route('about.aims') }}" class="subnav-pill {{ request()->routeIs('about.aims') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Our Aims & Objectives
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>
