{{-- Main Navigation --}}
<nav class="navbar" id="navbar" role="navigation" aria-label="Main navigation">
    <div class="container">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="nav-logo" aria-label="Department of Land Title Settlement Home">
            <img src="{{ asset('images/landTitle.jpg') }}" alt="Department Emblem" class="nav-logo-img">
            <div class="nav-logo-text">
                <div class="dept">Department of Land</div>
                <div class="dept">Title Settlement</div>
                <div class="sub">Sri Lanka</div>
            </div>
        </a>

        {{-- Desktop Nav --}}
        <ul class="nav-menu" id="nav-menu" role="menubar">

            {{-- Home --}}
            <li class="nav-item" role="none">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" role="menuitem" id="nav-home">HOME</a>
            </li>

            {{-- About Us --}}
            <li class="nav-item" role="none">
                <a href="{{ route('about') }}" class="nav-link {{ request()->is('about*') ? 'active' : '' }}" role="menuitem" aria-haspopup="true" aria-expanded="false" id="nav-about">
                    ABOUT US
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </a>
                <div class="dropdown" role="menu" aria-label="About Us submenu">
                    <div class="dropdown-header">About the Department</div>
                    <a href="{{ route('about.overview') }}" class="dropdown-item {{ request()->routeIs('about.overview') ? 'active-item' : '' }}" role="menuitem" id="nav-about-overview">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        <div>
                            <div style="font-weight:600;font-size:.88rem;">Overview</div>
                            <div style="font-size:.75rem;color:#9ca3af;margin-top:.1rem;">Vision, Mission & Aims</div>
                        </div>
                    </a>
                    <a href="{{ route('about.organization-chart') }}" class="dropdown-item {{ request()->routeIs('about.organization-chart') ? 'active-item' : '' }}" role="menuitem" id="nav-about-org">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                        </span>
                        <div>
                            <div style="font-weight:600;font-size:.88rem;">Organization Charts</div>
                            <div style="font-size:.75rem;color:#9ca3af;margin-top:.1rem;">Department structure & roles</div>
                        </div>
                    </a>
                    <a href="{{ route('about.aims') }}" class="dropdown-item {{ request()->routeIs('about.aims') ? 'active-item' : '' }}" role="menuitem" id="nav-about-aims">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        <div>
                            <div style="font-weight:600;font-size:.88rem;">Our Aims & Objectives</div>
                            <div style="font-size:.75rem;color:#9ca3af;margin-top:.1rem;">Key goals & statutory acts</div>
                        </div>
                    </a>
                </div>
            </li>

            {{-- Services --}}
            <li class="nav-item" role="none">
                <a href="{{ route('services') }}" class="nav-link {{ request()->is('services*') ? 'active' : '' }}" role="menuitem" aria-haspopup="true" aria-expanded="false" id="nav-services">
                    SERVICES
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </a>
                <div class="dropdown" role="menu" aria-label="Services submenu">
                    <div class="dropdown-header">Our Services</div>
                    <a href="{{ route('services.title-registration') }}" class="dropdown-item {{ request()->routeIs('services.title-registration') ? 'active-item' : '' }}" role="menuitem" id="nav-svc-title">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </span>
                        <div>
                            <div style="font-weight:600;font-size:.88rem;">Title Registration (Bimsaviya)</div>
                            <div style="font-size:.75rem;color:#9ca3af;margin-top:.1rem;">Torrens title & Bim Saviya programme</div>
                        </div>
                    </a>
                    <a href="{{ route('services.land-registration') }}" class="dropdown-item {{ request()->routeIs('services.land-registration') ? 'active-item' : '' }}" role="menuitem" id="nav-svc-settle">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                        </span>
                        <div>
                            <div style="font-weight:600;font-size:.88rem;">Land Registration &amp; Settlement</div>
                            <div style="font-size:.75rem;color:#9ca3af;margin-top:.1rem;">State &amp; private land settlement</div>
                        </div>
                    </a>
                </div>
            </li>

            {{-- News & Events --}}
            <li class="nav-item" role="none">
                <a href="{{ route('home') }}#news-events" class="nav-link" role="menuitem" id="nav-news">NEWS & EVENTS</a>
            </li>

            {{-- FAQ --}}
            <li class="nav-item" role="none">
                <a href="#" class="nav-link" role="menuitem" id="nav-faq">FAQ</a>
            </li>

            {{-- Downloads --}}
            <li class="nav-item" role="none">
                <a href="#" class="nav-link" role="menuitem" id="nav-downloads">DOWNLOADS</a>
            </li>

            {{-- Contact Us --}}
            <li class="nav-item" role="none">
                <a href="#" class="nav-link" role="menuitem" aria-haspopup="true" aria-expanded="false" id="nav-contact">
                    CONTACT US
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </a>
                <div class="dropdown" role="menu" aria-label="Contact Us submenu">
                    <div class="dropdown-header">Get In Touch</div>
                    <a href="#" class="dropdown-item" role="menuitem" id="nav-contact-head">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </span>
                        <div>
                            <div style="font-weight:600;font-size:.88rem;">Head Office</div>
                            <div style="font-size:.75rem;color:#9ca3af;margin-top:.1rem;">Battaramulla headquarters</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item" role="menuitem" id="nav-contact-regional">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        </span>
                        <div>
                            <div style="font-weight:600;font-size:.88rem;">Regional Offices</div>
                            <div style="font-size:.75rem;color:#9ca3af;margin-top:.1rem;">Offices across all districts</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item" role="menuitem" id="nav-contact-inquiry">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </span>
                        <div>
                            <div style="font-weight:600;font-size:.88rem;">Inquiry</div>
                            <div style="font-size:.75rem;color:#9ca3af;margin-top:.1rem;">Submit a query or complaint</div>
                        </div>
                    </a>
                </div>
            </li>

            {{-- Find --}}
            <li class="nav-item" role="none">
                <a href="#" class="nav-link nav-cta" role="menuitem" id="nav-find">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    FIND
                </a>
            </li>

        </ul>

        {{-- Hamburger --}}
        <button class="nav-hamburger" id="nav-hamburger" aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="nav-menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

    </div>
</nav>
