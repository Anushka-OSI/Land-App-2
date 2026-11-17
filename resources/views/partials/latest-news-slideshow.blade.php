{{-- Latest News Slideshow Section (always visible, no background images) --}}
<style>
    #latest-news-slideshow {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, var(--green-900), var(--green-700));
    }

    .news-section-label {
        position: absolute;
        top: 2rem;
        left: 0;
        right: 0;
        z-index: 10;
        text-align: center;
        font-family: var(--font-accent);
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--gold-500);
    }

    .slideshow-container {
        position: relative;
        height: 440px;
        width: 100%;
        display: flex;
        overflow: hidden;
    }

    .slide-item {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 1s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
    }

    .slide-item.active {
        opacity: 1;
        z-index: 2;
    }

    .slide-content {
        position: relative;
        z-index: 3;
        color: white;
        text-align: center;
        max-width: 800px;
        padding: 2rem;
        transform: translateY(30px);
        opacity: 0;
        transition: transform 1s ease 0.3s, opacity 1s ease 0.3s;
    }

    .slide-item.active .slide-content {
        transform: translateY(0);
        opacity: 1;
    }

    .slide-meta {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }

    .slide-date {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.75);
    }

    .slide-date svg {
        width: 16px;
        height: 16px;
    }

    .slide-category {
        display: inline-block;
        background: var(--gold-500);
        color: white;
        padding: 0.3rem 1rem;
        border-radius: 999px;
        font-family: var(--font-accent);
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    .slide-title {
        font-family: var(--font-heading);
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 1rem;
    }

    .slide-excerpt {
        font-size: 1.15rem;
        color: rgba(255, 255, 255, 0.85);
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .slideshow-controls {
        position: absolute;
        bottom: 2rem;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        z-index: 10;
    }

    .slide-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .slide-dot:hover {
        background: rgba(255, 255, 255, 0.7);
    }

    .slide-dot.active {
        background: var(--gold-500);
        transform: scale(1.2);
    }

    .slide-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s ease;
        backdrop-filter: blur(5px);
    }

    .slide-btn:hover {
        background: var(--gold-500);
        border-color: var(--gold-400);
        transform: translateY(-50%) scale(1.1);
    }

    .slide-prev {
        left: 2rem;
    }

    .slide-next {
        right: 2rem;
    }

    @media (max-width: 768px) {
        .slideshow-container {
            height: 480px;
        }

        .slide-title {
            font-size: 1.6rem;
        }

        .slide-excerpt {
            font-size: 1rem;
        }

        .slide-btn {
            display: none;
        }
    }
</style>

@if($latestNews->isNotEmpty())
<section id="latest-news-slideshow" aria-label="{{ __('Latest news') }}">
    <div class="news-section-label">{{ __('Latest News & Events') }}</div>
    <div class="slideshow-container">

        @foreach($latestNews as $index => $news)
            <div class="slide-item {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
                <div class="slide-content" lang="{{ $news['language'] }}">
                    <div class="slide-meta">
                        <span class="slide-category" lang="{{ app()->getLocale() }}">{{ $news['type'] }}</span>
                        <span class="slide-date" lang="{{ app()->getLocale() }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $news['date']->translatedFormat('F j, Y') }}
                        </span>
                    </div>
                    <h2 class="slide-title">{{ $news['title'] }}</h2>
                    <p class="slide-excerpt">{{ $news['excerpt'] }}</p>
                    <a href="{{ $news['url'] }}" class="btn btn-primary" lang="{{ app()->getLocale() }}"
                        style="background:var(--green-600);border:none;">{{ __('Read Full Story') }}</a>
                </div>
            </div>
        @endforeach

        <button class="slide-btn slide-prev" onclick="changeSlide(-1)" aria-label="{{ __('Previous slide') }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24"
                height="24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button class="slide-btn slide-next" onclick="changeSlide(1)" aria-label="{{ __('Next slide') }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24"
                height="24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>

        <div class="slideshow-controls">
            @foreach($latestNews as $index => $news)
                <div class="slide-dot {{ $index === 0 ? 'active' : '' }}" onclick="goToSlide({{ $index }})"></div>
            @endforeach
        </div>

    </div>
</section>

<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide-item');
    const dots = document.querySelectorAll('.slide-dot');
    let slideInterval;

    function showSlide(index) {
        slides.forEach(s => s.classList.remove('active'));
        dots.forEach(d => d.classList.remove('active'));

        currentSlide = (index + slides.length) % slides.length;

        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
    }

    function changeSlide(direction) {
        showSlide(currentSlide + direction);
        resetInterval();
    }

    function goToSlide(index) {
        showSlide(index);
        resetInterval();
    }

    function resetInterval() {
        clearInterval(slideInterval);
        slideInterval = setInterval(() => changeSlide(1), 6000);
    }

    // Start auto-slide
    resetInterval();
</script>
@endif
