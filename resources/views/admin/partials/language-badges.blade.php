{{-- Which languages an item is written in. Needs $item (uses HasTranslations) --}}
<span class="lang-badges">
    @foreach(\App\Support\Languages::ALL as $code => $lang)
        <span class="lang-badge {{ $item->hasLanguage($code) ? 'on' : '' }}" lang="{{ $code }}"
            title="{{ $lang['label'] }}: {{ $item->hasLanguage($code) ? 'added' : 'not added' }}">{{ $lang['short'] }}</span>
    @endforeach
</span>
