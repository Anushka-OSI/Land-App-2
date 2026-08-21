{{-- Footer --}}
<footer class="footer" id="footer" role="contentinfo" aria-label="Site footer">
    <div class="container">
        <div class="footer-grid">

            {{-- Col 1: Logo + Contact --}}
            <div class="footer-logo-col">
                <div class="footer-logo">
                    <img src="{{ asset('images/landTitle.jpg') }}" alt="Department Emblem" class="footer-logo-img">
                    <div class="footer-logo-text">
                        <div class="dept">Department of Land</div>
                        <div class="dept">Title Settlement</div>
                        <div class="sub">Sri Lanka</div>
                    </div>
                </div>
                <p class="footer-tagline">
                    Securing land ownership rights for every Sri Lankan citizen through transparent and accessible land management services.
                </p>
                <div class="footer-contact-info">
                    <div class="footer-contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        No 1200/6, Mihikatha Medura, Rajamalwatta Road, Battaramulla, Sri Lanka
                    </div>
                    <div class="footer-contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        +94 11 249 9450
                    </div>
                    <div class="footer-contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        info@landsettledept.gov.lk
                    </div>
                </div>
                <div class="social-links" aria-label="Social media links">
                    <a href="#" class="social-btn" aria-label="Facebook" id="social-facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                    </a>
                    <a href="#" class="social-btn" aria-label="Twitter / X" id="social-twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
                    </a>
                    <a href="#" class="social-btn" aria-label="Instagram" id="social-instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    </a>
                    <a href="#" class="social-btn" aria-label="YouTube" id="social-youtube">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="white"/></svg>
                    </a>
                </div>
            </div>

            {{-- Col 2: Related Links --}}
            <div>
                <h3 class="footer-col-title">Related Links</h3>
                <nav class="footer-links" aria-label="Related links">
                    @php
                        $relatedLinks = [
                            'Land Commissioner General\'s Department',
                            'Ministry of Land and Land Development',
                            'Survey Department',
                            'Registrar General\'s Department',
                            'Department of Government Printing',
                            'Official Facebook Page',
                        ];
                    @endphp
                    @foreach($relatedLinks as $link)
                    <a href="#" class="footer-link">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        {{ $link }}
                    </a>
                    @endforeach
                </nav>
            </div>

            {{-- Col 3: Quick Nav --}}
            <div>
                <h3 class="footer-col-title">Quick Navigation</h3>
                <nav class="footer-links" aria-label="Quick navigation">
                    @php
                        $quickNav = [
                            ['label' => 'Home',                   'href' => route('home')],
                            ['label' => 'About Us – Overview',    'href' => route('about.overview')],
                            ['label' => 'Organization Charts',    'href' => route('about.organization-chart')],
                            ['label' => 'Our Aims & Objectives',  'href' => route('about.aims')],
                            ['label' => 'Title Registration (Bimsaviya)',     'href' => route('services.title-registration')],
                            ['label' => 'Land Registration & Settlement',        'href' => route('services.land-registration')],
                            ['label' => 'News & Events',          'href' => route('home') . '#news-events'],
                            ['label' => 'FAQ',                    'href' => '#'],
                            ['label' => 'Downloads',              'href' => '#'],
                            ['label' => 'Head Office',            'href' => '#'],
                            ['label' => 'Regional Offices',       'href' => '#'],
                            ['label' => 'Inquiry',                'href' => '#'],
                        ];
                    @endphp
                    @foreach($quickNav as $nav)
                    <a href="{{ $nav['href'] }}" class="footer-link">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        {{ $nav['label'] }}
                    </a>
                    @endforeach
                </nav>
            </div>

            {{-- Col 4: Map --}}
            <div class="footer-map-col">
                <h3 class="footer-col-title">Find Us</h3>
                <div class="footer-map" aria-label="Department location map">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.798!2d79.9184!3d6.9271!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae25987b06f02d3%3A0x7ef7a490d2a40e82!2sMinistry%20of%20Lands!5e0!3m2!1sen!2slk!4v1"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Department of Land Title Settlement location"
                    ></iframe>
                </div>
                <div class="map-address">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    No 1200/6, Mihikatha Medura, Rajamalwatta Road, Battaramulla, Sri Lanka
                </div>

                <div style="margin-top:1.25rem;">
                    <div class="visitors-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:13px;height:13px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Visitors: <strong>106,661+</strong>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Footer Bottom --}}
    <div style="border-top:1px solid rgba(255,255,255,.08);">
        <div class="container">
            <div class="footer-bottom">
                <p class="footer-bottom-text">
                    &copy; {{ date('Y') }} Department of Land Title Settlement, Sri Lanka. All rights reserved.
                </p>
                <div class="footer-bottom-links">
                    <a href="#" class="footer-bottom-link">Privacy Policy</a>
                    <a href="#" class="footer-bottom-link">Terms of Use</a>
                    <a href="#" class="footer-bottom-link">Accessibility</a>
                    <a href="#" class="footer-bottom-link">Sitemap</a>
                </div>
            </div>
        </div>
    </div>
</footer>
