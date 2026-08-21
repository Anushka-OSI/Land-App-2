{{-- News & Events Section --}}
<section class="news-section" id="news-events" aria-label="Latest news and events">
    <div class="container">

        <div class="news-header">
            <div class="reveal">
                <span style="display:inline-block;font-family:'Outfit',sans-serif;font-size:.75rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#2d7a4f;background:#f0faf5;border:1px solid #d4f0e0;padding:.3rem .9rem;border-radius:999px;margin-bottom:.9rem;">Stay Informed</span>
                <h2 class="section-title">Latest News &amp; Events</h2>
                <p class="section-subtitle">Announcements, notices, and upcoming events from the Department</p>
            </div>
            <div class="reveal" style="display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap;">
                <div class="news-tabs" role="tablist" aria-label="News categories">
                    <button class="tab-btn active" data-tab="all" role="tab" aria-selected="true" aria-controls="tab-all" id="tab-btn-all">All</button>
                    <button class="tab-btn" data-tab="news" role="tab" aria-selected="false" aria-controls="tab-news" id="tab-btn-news">News</button>
                    <button class="tab-btn" data-tab="notice" role="tab" aria-selected="false" aria-controls="tab-notice" id="tab-btn-notice">Notices</button>
                    <button class="tab-btn" data-tab="event" role="tab" aria-selected="false" aria-controls="tab-event" id="tab-btn-event">Events</button>
                </div>
                <a href="#" class="see-all-link" id="news-see-all" aria-label="See all news and events">
                    See All
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>

        {{-- All Tab --}}
        <div class="news-panel active" id="tab-all" role="tabpanel" aria-labelledby="tab-btn-all">
            <div class="news-grid">
                @foreach($news as $item)
                <article class="news-card {{ strtolower($item['badge']) }} reveal" tabindex="0" aria-label="{{ $item['title'] }}">
                    <div class="news-card-top" aria-hidden="true"></div>
                    <div class="news-card-body">
                        <div class="news-card-meta">
                            <span class="badge badge-{{ $item['badge'] }}">
                                @if($item['badge'] === 'news')
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:10px;height:10px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9"/></svg>
                                @elseif($item['badge'] === 'notice')
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:10px;height:10px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:10px;height:10px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                @endif
                                {{ $item['category'] }}
                            </span>
                            <time class="news-date" datetime="{{ $item['date'] }}">
                                {{ \Carbon\Carbon::parse($item['date'])->format('M d, Y') }}
                            </time>
                        </div>
                        <h3 class="news-card-title">{{ $item['title'] }}</h3>
                        <p class="news-card-excerpt">{{ $item['excerpt'] }}</p>
                        <a href="#" class="news-read-more" id="news-item-{{ $item['id'] }}" aria-label="Read more about {{ $item['title'] }}">
                            Read More
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
        </div>

        {{-- News Tab --}}
        <div class="news-panel" id="tab-news" role="tabpanel" aria-labelledby="tab-btn-news">
            <div class="news-grid">
                @foreach($news->where('badge', 'news') as $item)
                <article class="news-card news reveal" tabindex="0">
                    <div class="news-card-top" aria-hidden="true"></div>
                    <div class="news-card-body">
                        <div class="news-card-meta">
                            <span class="badge badge-news">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:10px;height:10px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9"/></svg>
                                News
                            </span>
                            <time class="news-date" datetime="{{ $item['date'] }}">{{ \Carbon\Carbon::parse($item['date'])->format('M d, Y') }}</time>
                        </div>
                        <h3 class="news-card-title">{{ $item['title'] }}</h3>
                        <p class="news-card-excerpt">{{ $item['excerpt'] }}</p>
                        <a href="#" class="news-read-more">Read More <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></a>
                    </div>
                </article>
                @endforeach
            </div>
        </div>

        {{-- Notice Tab --}}
        <div class="news-panel" id="tab-notice" role="tabpanel" aria-labelledby="tab-btn-notice">
            <div class="news-grid">
                @foreach($news->where('badge', 'notice') as $item)
                <article class="news-card notice reveal" tabindex="0">
                    <div class="news-card-top" aria-hidden="true"></div>
                    <div class="news-card-body">
                        <div class="news-card-meta">
                            <span class="badge badge-notice">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:10px;height:10px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                Notice
                            </span>
                            <time class="news-date" datetime="{{ $item['date'] }}">{{ \Carbon\Carbon::parse($item['date'])->format('M d, Y') }}</time>
                        </div>
                        <h3 class="news-card-title">{{ $item['title'] }}</h3>
                        <p class="news-card-excerpt">{{ $item['excerpt'] }}</p>
                        <a href="#" class="news-read-more">Read More <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></a>
                    </div>
                </article>
                @endforeach
            </div>
        </div>

        {{-- Events Tab --}}
        <div class="news-panel" id="tab-event" role="tabpanel" aria-labelledby="tab-btn-event">
            <div class="news-grid">
                @foreach($news->where('badge', 'event') as $item)
                <article class="news-card event reveal" tabindex="0">
                    <div class="news-card-top" aria-hidden="true"></div>
                    <div class="news-card-body">
                        <div class="news-card-meta">
                            <span class="badge badge-event">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:10px;height:10px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Event
                            </span>
                            <time class="news-date" datetime="{{ $item['date'] }}">{{ \Carbon\Carbon::parse($item['date'])->format('M d, Y') }}</time>
                        </div>
                        <h3 class="news-card-title">{{ $item['title'] }}</h3>
                        <p class="news-card-excerpt">{{ $item['excerpt'] }}</p>
                        <a href="#" class="news-read-more">Read More <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></a>
                    </div>
                </article>
                @endforeach
            </div>
        </div>

    </div>
</section>
