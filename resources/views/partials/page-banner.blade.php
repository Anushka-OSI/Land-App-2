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
                    <a href="{{ route('about.overview') }}"
                        class="subnav-pill {{ request()->routeIs('about.overview') || request()->routeIs('about') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Overview
                    </a>
                    <a href="{{ route('about.organization-chart') }}"
                        class="subnav-pill {{ request()->routeIs('about.organization-chart') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0" />
                        </svg>
                        Organization Chart
                    </a>
                    <a href="{{ route('about.aims') }}"
                        class="subnav-pill {{ request()->routeIs('about.aims') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Our Aims & Objectives
                    </a>
                </div>
            @endif

            {{-- Contact Us Sub-navigation Tabs --}}
            @if(isset($showContactnav) && $showContactnav)
                <div class="about-subnav" role="tablist" aria-label="Contact Us subcategories">
                    <a href="{{ route('contact.inquiry') }}"
                        class="subnav-pill {{ request()->routeIs('contact.inquiry') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Inquiry
                    </a>
                    <a href="{{ route('contact.head-office') }}"
                        class="subnav-pill {{ request()->routeIs('contact.head-office') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Head Office
                    </a>
                    <a href="{{ route('contact.regional-office') }}"
                        class="subnav-pill {{ request()->routeIs('contact.regional-office') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        </svg>
                        Regional Offices
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>