{{--
    Read-only English / Sinhala / Tamil tabs for a news item or event (admin "View" page).
    @include('admin.partials.content-view', ['item' => $item, 'withPhotos' => true])
--}}
@php
    $langs = \App\Support\Languages::ALL;
    $withPhotos = $withPhotos ?? false;
    $active = $item->displayLanguage();
@endphp

<div class="lang-tabs" data-view-tabs>
    <div class="lang-tablist" role="tablist" aria-label="Content language">
        @foreach($langs as $code => $lang)
            <button type="button" role="tab" id="view-tab-{{ $code }}" aria-controls="view-panel-{{ $code }}"
                aria-selected="{{ $code === $active ? 'true' : 'false' }}" tabindex="{{ $code === $active ? '0' : '-1' }}"
                class="lang-tab {{ $code === $active ? 'active' : '' }} {{ $item->hasLanguage($code) ? 'filled' : '' }}"
                data-lang="{{ $code }}">
                <span class="lang-tab-name" lang="{{ $code }}">{{ $lang['native'] }}</span>
                @if($lang['native'] !== $lang['label'])
                    <span class="lang-tab-sub">{{ $lang['label'] }}</span>
                @endif
                <span class="lang-tab-status" aria-hidden="true"></span>
            </button>
        @endforeach
    </div>

    @foreach($langs as $code => $lang)
        <div class="lang-panel view-panel" role="tabpanel" id="view-panel-{{ $code }}" aria-labelledby="view-tab-{{ $code }}"
            data-lang="{{ $code }}" @if($code !== $active) hidden @endif>

            @if(! $item->hasLanguage($code))
                <p class="view-empty">No {{ $lang['label'] }} version has been added. Visitors reading in
                    {{ $lang['label'] }} see another available language instead.</p>
            @else
                <div lang="{{ $code }}">
                    <h2 class="view-title">{{ $item->getAttribute("title_{$code}") }}</h2>

                    @if(filled($item->getAttribute("excerpt_{$code}")))
                        <p class="view-excerpt">{{ $item->getAttribute("excerpt_{$code}") }}</p>
                    @endif

                    @if(filled($item->getAttribute("body_{$code}")))
                        <div class="rich-content">{!! $item->getAttribute("body_{$code}") !!}</div>
                    @endif
                </div>

                @if($withPhotos)
                    @php $images = $item->imagesFor($code); @endphp
                    <h3 class="panel-subtitle view-photos-title">Photos ({{ $images->count() }})</h3>
                    @if($images->isEmpty())
                        <p class="view-empty">No {{ $lang['label'] }} photos.</p>
                    @else
                        <div class="image-grid">
                            @foreach($images as $image)
                                <a href="{{ $image->url }}" target="_blank" class="image-tile">
                                    <img src="{{ $image->url }}" alt="{{ $lang['label'] }} photo {{ $loop->iteration }}">
                                    @if($loop->first)
                                        <span class="image-tag">Cover</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @endif
                @endif
            @endif
        </div>
    @endforeach
</div>

@once
    @push('scripts')
        <script>
            document.querySelectorAll('[data-view-tabs]').forEach(root => {
                const tabs = [...root.querySelectorAll('[role="tab"]')];
                const panels = [...root.querySelectorAll('[role="tabpanel"]')];
                const select = (tab, focus) => {
                    tabs.forEach(t => {
                        const on = t === tab;
                        t.classList.toggle('active', on);
                        t.setAttribute('aria-selected', on ? 'true' : 'false');
                        t.tabIndex = on ? 0 : -1;
                    });
                    panels.forEach(p => p.hidden = p.dataset.lang !== tab.dataset.lang);
                    if (focus) tab.focus();
                };
                tabs.forEach((tab, i) => {
                    tab.addEventListener('click', () => select(tab));
                    tab.addEventListener('keydown', e => {
                        const move = { ArrowRight: 1, ArrowLeft: -1 }[e.key];
                        if (move) { e.preventDefault(); select(tabs[(i + move + tabs.length) % tabs.length], true); }
                    });
                });
            });
        </script>
    @endpush
@endonce
