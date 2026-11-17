@extends('layouts.app')

@php
    $shown = $item->displayLanguage($lang);
    $photos = $item->imagesFor($shown); // photos added in this language's tab only
@endphp

@section('title', __(':title | Events | Department of Land Title Settlement', ['title' => $item->t('title', $lang)]))

@section('content')

    @include('partials.page-banner', [
        'title' => __('Events'),
        'subtitle' => __('Programs, trainings and events of the Department'),
        'showSubnav' => false
    ])

    <section class="article-section">
        <div class="container article-container">
            <div class="article-topbar">
                <a href="{{ route('news') }}" class="article-back">&larr; {{ __('Back to News & Events') }}</a>
                @if(count($item->availableLanguages()) > 1)
                    @include('partials.content-language-switch', [
                        'lang' => $shown,
                        'url' => route('events.show', $item),
                        'available' => $item->availableLanguages(),
                    ])
                @endif
            </div>

            <article class="article" lang="{{ $shown }}">
                <div class="article-meta" lang="{{ app()->getLocale() }}">
                    <span class="badge badge-event">{{ __('Event') }}</span>
                    <time datetime="{{ $item->event_date->format('Y-m-d') }}">{{ $item->event_date->translatedFormat('F j, Y') }}</time>
                </div>

                @if($shown !== $lang)
                    <p class="article-notice" lang="{{ app()->getLocale() }}">{{ __('This event is not available in :language. Showing :shown.', ['language' => \App\Support\Languages::native($lang), 'shown' => \App\Support\Languages::native($shown)]) }}</p>
                @endif

                <h1 class="article-title">{{ $item->t('title', $lang) }}</h1>
                <p class="article-lead">{{ $item->t('excerpt', $lang) }}</p>

                @if($photos->isNotEmpty())
                    <div class="event-gallery {{ $photos->count() === 1 ? 'single' : '' }}" aria-label="{{ __('Event photos') }}">
                        @foreach($photos as $i => $image)
                            <button type="button" class="event-gallery-item" data-index="{{ $i }}"
                                aria-label="{{ __('Open photo :n of :total', ['n' => $i + 1, 'total' => $photos->count()]) }}">
                                <img src="{{ $image->url }}" alt="{{ __('Photo :n – :title', ['n' => $i + 1, 'title' => $item->t('title', $lang)]) }}" loading="lazy">
                            </button>
                        @endforeach
                    </div>
                @endif

                @if($item->t('body', $lang))
                    <div class="rich-content">{!! $item->t('body', $lang) !!}</div>
                @endif
            </article>

            @if($related->isNotEmpty())
                <aside class="article-related" aria-label="{{ __('More events') }}">
                    <h2>{{ __('More Events') }}</h2>
                    <ul>
                        @foreach($related as $other)
                            <li lang="{{ $other->displayLanguage($lang) }}">
                                <a href="{{ route('events.show', $other) }}">{{ $other->t('title', $lang) }}</a>
                                <time lang="{{ app()->getLocale() }}">{{ $other->event_date->translatedFormat('M j, Y') }}</time>
                            </li>
                        @endforeach
                    </ul>
                </aside>
            @endif
        </div>
    </section>

    @if($photos->isNotEmpty())
        {{-- Full-screen photo viewer --}}
        <div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-label="{{ __('Photo viewer') }}" hidden>
            <button type="button" class="lightbox-close" aria-label="{{ __('Close') }}">&times;</button>
            <button type="button" class="lightbox-nav prev" aria-label="{{ __('Previous photo') }}">&#8249;</button>
            <img src="" alt="" class="lightbox-img">
            <button type="button" class="lightbox-nav next" aria-label="{{ __('Next photo') }}">&#8250;</button>
            <div class="lightbox-count"></div>
        </div>
    @endif

@endsection

@if($photos->isNotEmpty())
    @push('scripts')
        @php
            // built here because @json() cannot contain commas
            $photoList = $photos->map(fn ($img, $i) => ['src' => $img->url, 'alt' => __('Photo :n', ['n' => $i + 1])])->values();
        @endphp
        <script>
            (function () {
                const photos = @json($photoList);
                const box = document.getElementById('lightbox');
                const img = box.querySelector('.lightbox-img');
                const count = box.querySelector('.lightbox-count');
                let current = 0, opener = null;

                function show(i) {
                    current = (i + photos.length) % photos.length;
                    img.src = photos[current].src;
                    img.alt = photos[current].alt;
                    count.textContent = (current + 1) + ' / ' + photos.length;
                }
                function open(i, from) {
                    opener = from; show(i); box.hidden = false;
                    document.body.style.overflow = 'hidden';
                    box.querySelector('.lightbox-close').focus();
                }
                function close() {
                    box.hidden = true; document.body.style.overflow = '';
                    if (opener) opener.focus();
                }

                document.querySelectorAll('.event-gallery-item').forEach(btn =>
                    btn.addEventListener('click', () => open(+btn.dataset.index, btn)));
                box.querySelector('.lightbox-close').addEventListener('click', close);
                box.querySelector('.prev').addEventListener('click', () => show(current - 1));
                box.querySelector('.next').addEventListener('click', () => show(current + 1));
                box.addEventListener('click', e => { if (e.target === box) close(); });
                document.addEventListener('keydown', e => {
                    if (box.hidden) return;
                    if (e.key === 'Escape') close();
                    if (e.key === 'ArrowLeft') show(current - 1);
                    if (e.key === 'ArrowRight') show(current + 1);
                });
                if (photos.length < 2) box.querySelectorAll('.lightbox-nav').forEach(b => b.hidden = true);
            })();
        </script>
    @endpush
@endif
