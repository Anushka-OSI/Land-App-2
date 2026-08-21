{{-- Services Section --}}
<section class="services-section" id="services" aria-label="Our services">
    <div class="container">

        <div class="services-header reveal">
            <span class="label">What We Offer</span>
            <h2 class="section-title">Our Core Services</h2>
            <p class="section-subtitle">Providing comprehensive land management solutions for Sri Lanka's citizens</p>
        </div>

        <div class="services-grid">

            {{-- Title Registration Card --}}
            <article class="service-card reveal-left" id="service-title-registration" tabindex="0" role="article" aria-label="Title Registration service">
                <div class="service-card-bg" style="background-image:url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=900&q=80');" aria-hidden="true"></div>
                <div class="service-card-overlay" aria-hidden="true"></div>
                <div class="service-card-body">
                    <div class="service-icon-wrap" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <span class="service-tag">Service 01</span>
                    <h3 class="service-card-title">Title Registration</h3>
                    <p class="service-card-desc">
                        The formal process of recording and certifying land ownership rights under the Registration of Title Act No. 21 of 1998, ensuring secure and indefeasible titles for every land parcel.
                    </p>
                    <a href="{{ route('services.title-registration') }}" class="service-link" id="service-title-link" aria-label="Learn more about Title Registration">
                        Learn More
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </article>

            {{-- Land Settlement Card --}}
            <article class="service-card reveal-right" id="service-land-settlement" tabindex="0" role="article" aria-label="Land Settlement service">
                <div class="service-card-bg" style="background-image:url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=900&q=80');" aria-hidden="true"></div>
                <div class="service-card-overlay" aria-hidden="true"></div>
                <div class="service-card-body">
                    <div class="service-icon-wrap" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                    </div>
                    <span class="service-tag">Service 02</span>
                    <h3 class="service-card-title">Land Settlement</h3>
                    <p class="service-card-desc">
                        The process of determining which lands are state-owned and which are privately held within Sri Lanka's territory — transferring private lands to respective heirs and issuing plans for such lands.
                    </p>
                    <a href="{{ route('services.land-registration') }}" class="service-link" id="service-settle-link" aria-label="Learn more about Land Settlement">
                        Learn More
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </article>

        </div>
    </div>
</section>
