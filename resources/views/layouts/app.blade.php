<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ __('The Department of Land Title Settlement of Sri Lanka – providing title registration and land settlement services across all districts.') }}">
    <meta name="keywords" content="land title settlement, Sri Lanka, title registration, land settlement, department">
    <meta name="author" content="{{ __('Department of Land Title Settlement') }}">
    <meta property="og:title" content="{{ __('Department of Land Title Settlement | Sri Lanka') }}">
    <meta property="og:description" content="{{ __('A settled title for every land. Official website of the Department of Land Title Settlement, Sri Lanka.') }}">
    <title>@yield('title', __('Department of Land Title Settlement | Sri Lanka'))</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&family=Noto+Sans+Sinhala:wght@400..800&family=Noto+Sans+Tamil:wght@400..800&display=swap" rel="stylesheet">

    {{-- App CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/language.css') }}">
    <link rel="stylesheet" href="{{ asset('css/event-calendar.css') }}">

    @stack('styles')
</head>
<body class="locale-{{ app()->getLocale() }}{{ $languageChosen ?? true ? '' : ' has-language-gate' }}">

    {{-- First visit: choose Sinhala / Tamil / English --}}
    @unless($languageChosen ?? true)
        @include('partials.language-chooser')
    @endunless

    {{-- Top Info Bar --}}
    @include('partials.topbar')

    {{-- Navigation --}}
    @include('partials.navbar')

    {{-- Main Content --}}
    <main id="main-content">
        @yield('content')
    </main>

    {{-- Event Calendar: tab on the right side of every page, opens a full-screen calendar --}}
    @include('partials.event-calendar')

    {{-- Related Government Organizations (Global across all pages) --}}
    @include('partials.organizations')

    {{-- Footer --}}
    @include('partials.footer')

    {{-- Back to Top --}}
    <button class="back-to-top" aria-label="{{ __('Back to top') }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
    </button>

    {{-- App JS --}}
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/event-calendar.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
