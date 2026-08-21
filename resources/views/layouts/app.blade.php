<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="The Department of Land Title Settlement of Sri Lanka – providing title registration and land settlement services across all districts.">
    <meta name="keywords" content="land title settlement, Sri Lanka, title registration, land settlement, department">
    <meta name="author" content="Department of Land Title Settlement">
    <meta property="og:title" content="Department of Land Title Settlement | Sri Lanka">
    <meta property="og:description" content="A settled title for every land. Official website of the Department of Land Title Settlement, Sri Lanka.">
    <title>@yield('title', 'Department of Land Title Settlement | Sri Lanka')</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- App CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')
</head>
<body>

    {{-- Top Info Bar --}}
    @include('partials.topbar')

    {{-- Navigation --}}
    @include('partials.navbar')

    {{-- Main Content --}}
    <main id="main-content">
        @yield('content')
    </main>

    {{-- Related Government Organizations (Global across all pages) --}}
    @include('partials.organizations')

    {{-- Footer --}}
    @include('partials.footer')

    {{-- Back to Top --}}
    <button class="back-to-top" aria-label="Back to top">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
    </button>

    {{-- App JS --}}
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
