{{-- Hero Section --}}
<section class="hero" id="hero" aria-label="{{ __('Homepage hero banner') }}">

    {{-- Background with parallax --}}
    <div class="hero-bg" id="hero-bg" aria-hidden="true"></div>
    <div class="hero-overlay" aria-hidden="true"></div>
    <div class="hero-particles" aria-hidden="true"></div>

    <div class="container">
        <div class="hero-content">

            {{-- Eyebrow --}}
            <div class="hero-eyebrow">
                {{ __('Official Government Portal of Sri Lanka') }}
            </div>

            {{-- Title --}}
            <h1 class="hero-title">
                {!! __('The Department of<br> <span class="highlight">Land Title Settlement</span>') !!}
            </h1>

            {{-- Description --}}
            <p class="hero-desc">
                {{ __('Securing land ownership rights for every Sri Lankan citizen through transparent title registration and land settlement services across all 25 districts.') }}
            </p>

            {{-- NIC Search -> opens the Find Land page with ?nic=... --}}
            <form class="hero-search" action="{{ route('find') }}" method="GET" role="search"
                aria-label="{{ __('Search land records by NIC') }}" novalidate>
                <label for="hero-nic" class="sr-only">{{ __('NIC Number') }}</label>
                <svg class="hero-search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" id="hero-nic" name="nic" class="hero-search-input"
                    placeholder="{{ __('Enter your NIC number to find your land records') }}" autocomplete="off"
                    maxlength="12" pattern="^([0-9]{9}[vVxX]|[0-9]{12})$" required>
                <button type="submit" class="hero-search-btn">{{ __('Search') }}</button>
            </form>
            <small class="hero-search-error" id="hero-nic-error" role="alert"></small>

            {{-- CTAs --}}
            <div class="hero-actions">
                <a href="#services" class="btn btn-primary" id="hero-cta-services">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        style="width:18px;height:18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    {{ __('Our Services') }}
                </a>
            </div>

        </div>
    </div>



    {{-- Scroll Indicator --}}
    <div class="hero-scroll" onclick="document.getElementById('stats').scrollIntoView({behavior:'smooth'})"
        role="button" tabindex="0" aria-label="{{ __('Scroll down') }}">
        <span>{{ __('Scroll') }}</span>
        <div class="scroll-line"></div>
    </div>

</section>

@push('scripts')
    <script>
        // NIC search: validate (old 9 digits + V/X, or new 12 digits) before going to the Find Land page
        (function () {
            const form = document.querySelector('.hero-search');
            if (!form) return;
            const input = document.getElementById('hero-nic');
            const error = document.getElementById('hero-nic-error');

            form.addEventListener('submit', function (event) {
                const nic = input.value.trim().toUpperCase();
                input.value = nic;

                if (!nic) {
                    error.textContent = @json(__('Please enter your NIC number.'));
                } else if (!/^([0-9]{9}[VX]|[0-9]{12})$/.test(nic)) {
                    error.textContent = @json(__('Enter a valid NIC (e.g. 851234567V or 198512345678).'));
                } else {
                    error.textContent = '';
                    return; // valid -> submit to /find?nic=...
                }
                event.preventDefault();
                input.focus();
            });

            input.addEventListener('input', () => { error.textContent = ''; });
        })();
    </script>
@endpush