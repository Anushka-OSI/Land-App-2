{{-- One News & Notices / Event card. $lang = reading language (optional). $card = ['kind','title','excerpt','date','language','url','image','images_count'] --}}
<article class="news-card {{ $card['kind'] }} reveal" lang="{{ $card['language'] }}">
    @if($card['kind'] === 'event' && $card['image'])
        <a href="{{ $card['url'] }}" class="news-card-image" tabindex="-1" aria-hidden="true">
            <img src="{{ $card['image'] }}" alt="" loading="lazy">
            @if($card['images_count'] > 1)
                <span class="news-card-photos">{{ __(':count photos', ['count' => $card['images_count']]) }}</span>
            @endif
        </a>
    @else
        <div class="news-card-top" aria-hidden="true"></div>
    @endif
    <div class="news-card-body">
        <div class="news-card-meta" lang="{{ app()->getLocale() }}">
            <span class="badge badge-{{ $card['kind'] }}">
                {{ $card['kind'] === 'event' ? __('Event') : __('News & Notices') }}
            </span>
            @if(isset($lang) && $card['language'] !== $lang)
                {{-- Not written in the chosen language – say which one is shown instead --}}
                <span class="news-card-lang" title="{{ __('Not available in :language', ['language' => \App\Support\Languages::native($lang)]) }}">
                    {{ \App\Support\Languages::native($card['language']) }}
                </span>
            @endif
        </div>
        <time class="news-date" lang="{{ app()->getLocale() }}" datetime="{{ $card['date']->format('Y-m-d') }}">{{ $card['date']->translatedFormat('M d, Y') }}</time>
        <h3 class="news-card-title"><a href="{{ $card['url'] }}">{{ $card['title'] }}</a></h3>
        <p class="news-card-excerpt">{{ $card['excerpt'] }}</p>
        <a href="{{ $card['url'] }}" class="news-read-more" lang="{{ app()->getLocale() }}" aria-label="{{ __('Read more: :title', ['title' => $card['title']]) }}">
            {{ __('Read More') }}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        </a>
    </div>
</article>
