{{-- News & Events Section. Needs $news (News models), $events (Event models), $lang (reading language) --}}
@php
    $newsCards = $news->map(fn ($n) => [
        'kind' => 'news', 'title' => $n->t('title', $lang), 'excerpt' => $n->t('excerpt', $lang), 'date' => $n->published_at,
        'language' => $n->displayLanguage($lang), 'url' => route('news.show', $n), 'image' => null, 'images_count' => 0,
    ]);
    // Event photos belong to one language – use the photos of the language being shown (may be none)
    $eventCards = $events->map(function ($e) use ($lang) {
        $shown = $e->displayLanguage($lang);
        $photos = $e->imagesFor($shown);

        return [
            'kind' => 'event', 'title' => $e->t('title', $lang), 'excerpt' => $e->t('excerpt', $lang), 'date' => $e->event_date,
            'language' => $shown, 'url' => route('events.show', $e),
            'image' => $photos->first()?->url, 'images_count' => $photos->count(),
        ];
    });
    $allCards = $newsCards->concat($eventCards)->sortByDesc(fn ($c) => $c['date']->timestamp)->values();
    $tabs = [
        'all' => ['label' => __('All'), 'cards' => $allCards],
        'news' => ['label' => __('News & Notices'), 'cards' => $newsCards],
        'event' => ['label' => __('Events'), 'cards' => $eventCards],
    ];
@endphp

<section class="news-section" id="news-events" aria-label="{{ __('Latest news and events') }}">
    <div class="container">

        <div class="news-header">
            <div class="reveal">
                <span
                    style="display:inline-block;font-family:var(--font-accent);font-size:.75rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#2d7a4f;background:#f0faf5;border:1px solid #d4f0e0;padding:.3rem .9rem;border-radius:999px;margin-bottom:.9rem;">{{ __('Stay Informed') }}</span>
                <h2 class="section-title">{{ __('Latest News & Events') }}</h2>
                <p class="section-subtitle">{{ __('Announcements, notices, and events from the Department') }}</p>
            </div>
            <div class="reveal news-header-controls">
                <div class="news-tabs" role="tablist" aria-label="{{ __('News categories') }}">
                    @foreach($tabs as $key => $tab)
                        <button class="tab-btn {{ $loop->first ? 'active' : '' }}" data-tab="{{ $key }}" role="tab"
                            aria-selected="{{ $loop->first ? 'true' : 'false' }}" aria-controls="tab-{{ $key }}"
                            id="tab-btn-{{ $key }}">{{ $tab['label'] }}</button>
                    @endforeach
                </div>
            </div>
        </div>

        @foreach($tabs as $key => $tab)
            <div class="news-panel {{ $loop->first ? 'active' : '' }}" id="tab-{{ $key }}" role="tabpanel"
                aria-labelledby="tab-btn-{{ $key }}">
                @if($tab['cards']->isEmpty())
                    <p class="news-empty">{{ __('Nothing to show here yet.') }}</p>
                @else
                    <div class="news-grid">
                        @foreach($tab['cards'] as $card)
                            @include('partials.news-card', ['card' => $card, 'lang' => $lang])
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach

    </div>
</section>
