{{--
    Language switcher: සිංහල | தமிழ் | English
    Optional: $variant = 'topbar' (default) | 'menu' (inside the mobile menu)
--}}
@php $current = \App\Support\Languages::current(); @endphp
<nav class="language-switcher language-switcher--{{ $variant ?? 'topbar' }}" aria-label="{{ __('Choose language') }}">
    <svg class="language-switcher-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
    @foreach(\App\Support\Languages::DISPLAY_ORDER as $code)
        <a href="{{ \App\Support\Languages::switchUrl($code) }}" lang="{{ $code }}" hreflang="{{ $code }}"
            class="language-switcher-link {{ $current === $code ? 'active' : '' }}"
            @if($current === $code) aria-current="true" @endif>{{ \App\Support\Languages::native($code) }}</a>
    @endforeach
</nav>
