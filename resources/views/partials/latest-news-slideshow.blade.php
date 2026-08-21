{{-- Latest News Background Slideshow Section --}}
<style>
    #latest-news-slideshow {
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        transition: max-height 0.8s ease-in-out, opacity 0.8s ease-in-out;
        will-change: max-height, opacity;
        background: #000;
        position: relative;
    }

    #latest-news-slideshow.visible {
        max-height: 700px;
        /* Adjust according to design */
        opacity: 1;
    }

    .slideshow-container {
        position: relative;
        height: 500px;
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

    .slide-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        filter: brightness(0.4) contrast(1.1);
        transform: scale(1.05);
        transition: transform 6s linear;
    }

    .slide-item.active .slide-bg {
        transform: scale(1);
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
        margin-bottom: 1rem;
    }

    .slide-title {
        font-family: var(--font-heading);
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 1rem;
        text-shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
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
</style>

<div id="latest-news-slideshow">
    <div class="slideshow-container">

        @foreach($latestNews as $index => $news)
            <div class="slide-item {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
                <div class="slide-bg" style="background-image: url('{{ $news["image"] }}');"></div>
                <div class="slide-content">
                    <span class="slide-category">{{ $news['category'] }}</span>
                    <h2 class="slide-title">{{ $news['title'] }}</h2>
                    <p class="slide-excerpt">{{ $news['excerpt'] }}</p>
                    <a href="{{ route('news') }}" class="btn btn-primary"
                        style="background:var(--green-600);border:none;">Read Full Story</a>
                </div>
            </div>
        @endforeach

        <button class="slide-btn slide-prev" onclick="changeSlide(-1)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24"
                height="24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button class="slide-btn slide-next" onclick="changeSlide(1)">
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
</div>

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