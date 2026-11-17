{{--
    "Read in: English | සිංහල | தமிழ்" switch on a News / Event page. Shows this one item in
    another language (?read=xx) without changing the language of the whole website.
    Needs $lang (current) and $url (page to reload). Optional $available = language codes the item has.
--}}
@php $available = $available ?? \App\Support\Languages::codes(); @endphp
<nav class="news-lang-filter reveal" aria-label="{{ __('Choose language') }}">
    <span class="news-lang-label">{{ __('Read in:') }}</span>
    @foreach(\App\Support\Languages::ALL as $code => $info)
        @if(in_array($code, $available, true))
            <a href="{{ $url }}?read={{ $code }}" lang="{{ $code }}" hreflang="{{ $code }}"
                class="lang-chip {{ $lang === $code ? 'active' : '' }}" @if($lang === $code) aria-current="true" @endif>{{ $info['native'] }}</a>
        @endif
    @endforeach
</nav>
