{{--
    English / Sinhala / Tamil tabs: title, short description and full story for each language.
    @include('admin.partials.translation-tabs', ['item' => $item])
    Optional 'panelExtra' => view name, included at the end of every language panel with $lang + $item
    (the Events form uses it for the per-language photos).
--}}
@php
    $langs = \App\Support\Languages::ALL;
    $hasError = fn ($lang) => $errors->hasAny(["title_{$lang}", "excerpt_{$lang}", "body_{$lang}", "images_{$lang}", "images_{$lang}.*"]);
    $isFilled = fn ($lang) => filled(old("title_{$lang}", $item->getAttribute("title_{$lang}")));
    $active = collect(array_keys($langs))->first(fn ($lang) => $hasError($lang)) ?? 'en';
@endphp

<div class="lang-tabs" data-lang-tabs>
    <p class="lang-tabs-help">Write this item in one, two or all three languages. Leave a language empty to skip it – the
        website then shows another available language instead.</p>

    <div class="lang-tablist" role="tablist" aria-label="Content language">
        @foreach($langs as $code => $lang)
            <button type="button" role="tab" id="lang-tab-{{ $code }}" aria-controls="lang-panel-{{ $code }}"
                aria-selected="{{ $code === $active ? 'true' : 'false' }}" tabindex="{{ $code === $active ? '0' : '-1' }}"
                class="lang-tab {{ $code === $active ? 'active' : '' }} {{ $hasError($code) ? 'has-error' : '' }} {{ $isFilled($code) ? 'filled' : '' }}"
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
        <div class="lang-panel" role="tabpanel" id="lang-panel-{{ $code }}" aria-labelledby="lang-tab-{{ $code }}"
            data-lang="{{ $code }}" @if($code !== $active) hidden @endif>

            <div class="form-group">
                <label for="title_{{ $code }}">Title <span class="hint">({{ $lang['label'] }})</span></label>
                <input type="text" id="title_{{ $code }}" name="title_{{ $code }}" lang="{{ $code }}" maxlength="255"
                    value="{{ old("title_{$code}", $item->getAttribute("title_{$code}")) }}"
                    class="form-input @error("title_{$code}") is-invalid @enderror">
                @error("title_{$code}") <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="excerpt_{{ $code }}">Short description <span class="hint">({{ $lang['label'] }} – shown on cards
                        and the homepage, max 500 characters)</span></label>
                <textarea id="excerpt_{{ $code }}" name="excerpt_{{ $code }}" lang="{{ $code }}" rows="3" maxlength="500"
                    class="form-input @error("excerpt_{$code}") is-invalid @enderror">{{ old("excerpt_{$code}", $item->getAttribute("excerpt_{$code}")) }}</textarea>
                @error("excerpt_{$code}") <small class="form-error">{{ $message }}</small> @enderror
            </div>

            @include('admin.partials.rich-editor', [
                'name' => "body_{$code}",
                'lang' => $code,
                'label' => 'Full story',
                'labelHint' => $lang['label'],
                'value' => old("body_{$code}", $item->getAttribute("body_{$code}")),
            ])

            @isset($panelExtra)
                @include($panelExtra, ['lang' => $code, 'item' => $item])
            @endisset
        </div>
    @endforeach
</div>

@once
    @push('scripts')
        <script>
            document.querySelectorAll('[data-lang-tabs]').forEach(function (root) {
                const tabs = [...root.querySelectorAll('.lang-tab')];
                const panels = [...root.querySelectorAll('.lang-panel')];

                function select(tab, focus) {
                    tabs.forEach(t => {
                        const on = t === tab;
                        t.classList.toggle('active', on);
                        t.setAttribute('aria-selected', on ? 'true' : 'false');
                        t.tabIndex = on ? 0 : -1;
                    });
                    panels.forEach(p => p.hidden = p.dataset.lang !== tab.dataset.lang);
                    if (focus) tab.focus();
                }

                tabs.forEach((tab, i) => {
                    tab.addEventListener('click', () => select(tab));
                    tab.addEventListener('keydown', e => {
                        const move = { ArrowRight: 1, ArrowLeft: -1 }[e.key];
                        if (move) { e.preventDefault(); select(tabs[(i + move + tabs.length) % tabs.length], true); }
                    });
                });

                // Tick on the tab when that language has a title
                panels.forEach(panel => {
                    const title = panel.querySelector('input[name^="title_"]');
                    const tab = tabs.find(t => t.dataset.lang === panel.dataset.lang);
                    title.addEventListener('input', () => tab.classList.toggle('filled', title.value.trim() !== ''));
                });
            });
        </script>
    @endpush
@endonce
