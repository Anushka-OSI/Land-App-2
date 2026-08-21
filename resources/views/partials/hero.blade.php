{{-- Hero Section --}}
<section class="hero" id="hero" aria-label="Homepage hero banner">

    {{-- Background with parallax --}}
    <div class="hero-bg" id="hero-bg" aria-hidden="true"></div>
    <div class="hero-overlay" aria-hidden="true"></div>
    <div class="hero-particles" aria-hidden="true"></div>

    <div class="container">
        <div class="hero-content">

            {{-- Eyebrow --}}
            <div class="hero-eyebrow">
                Official Government Portal of Sri Lanka
            </div>

            {{-- Title --}}
            <h1 class="hero-title">
                The Department of<br>
                <span class="highlight">Land Title Settlement</span>
            </h1>

            {{-- Description --}}
            <p class="hero-desc">
                Securing land ownership rights for every Sri Lankan citizen through transparent title registration and land settlement services across all 25 districts.
            </p>

            {{-- CTAs --}}
            <div class="hero-actions">
                <a href="#services" class="btn btn-primary" id="hero-cta-services">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Our Services
                </a>
                <a href="#news-events" class="btn btn-outline" id="hero-cta-news">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9"/></svg>
                    Latest News
                </a>
            </div>

        </div>
    </div>

  

    {{-- Scroll Indicator --}}
    <div class="hero-scroll" onclick="document.getElementById('stats').scrollIntoView({behavior:'smooth'})" role="button" tabindex="0" aria-label="Scroll down">
        <span>Scroll</span>
        <div class="scroll-line"></div>
    </div>

</section>
