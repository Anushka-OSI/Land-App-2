<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Dashboard') | Admin – Land Title Settlement</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&family=Noto+Sans+Sinhala:wght@400..800&family=Noto+Sans+Tamil:wght@400..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
</head>

<body class="admin-body">

    @php
        $newMessages = \App\Models\Message::where('status', 'new')->count();
        $nav = [
            // Daily: check first
            ['route' => 'admin.dashboard', 'active' => 'admin.dashboard', 'label' => 'Dashboard',
                'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
            ['route' => 'admin.messages.index', 'active' => 'admin.messages.*', 'label' => 'Messages', 'badge' => $newMessages,
                'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
            // Website content, most often updated first
            ['route' => 'admin.news.index', 'active' => 'admin.news.*', 'label' => 'News & Notices',
                'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'],
            ['route' => 'admin.events.index', 'active' => 'admin.events.*', 'label' => 'Events',
                'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
            ['route' => 'admin.calendar.index', 'active' => 'admin.calendar.*', 'label' => 'Event Calendar',
                'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2zM9 15h.01M12 15h.01M15 15h.01'],
            // Contact details (rarely changed)
            ['route' => 'admin.head-office.index', 'active' => 'admin.head-office*', 'label' => 'Head Office',
                'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
            ['route' => 'admin.regional-offices.index', 'active' => 'admin.regional-offices.*', 'label' => 'Regional Offices',
                'icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z'],
            // FAQs last
            ['route' => 'admin.faqs.index', 'active' => 'admin.faqs.*', 'label' => 'FAQs',
                'icon' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ];
    @endphp

    {{-- Sidebar --}}
    <aside class="admin-sidebar" id="admin-sidebar">
        <a href="{{ route('admin.dashboard') }}" class="admin-brand">
            <img src="{{ asset('images/landTitle.jpg') }}" alt="" class="admin-brand-logo">
            <div>
                <div class="admin-brand-title">Land Title Settlement</div>
                <div class="admin-brand-sub">Admin Panel</div>
            </div>
        </a>

        <nav class="admin-nav" aria-label="Admin navigation">
            @foreach($nav as $item)
                <a href="{{ route($item['route']) }}"
                    class="admin-nav-link {{ request()->routeIs($item['active']) ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                    </svg>
                    <span>{{ $item['label'] }}</span>
                    @if(!empty($item['badge']))
                        <span class="admin-nav-badge">{{ $item['badge'] }}</span>
                    @endif
                </a>
            @endforeach
        </nav>

        <div class="admin-sidebar-footer">
            <a href="{{ route('admin.profile.edit') }}"
                class="admin-nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>My Account</span>
            </a>
            <a href="{{ route('home') }}" target="_blank" class="admin-nav-link">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                <span>View Website</span>
            </a>
        </div>
    </aside>

    {{-- Main --}}
    <div class="admin-main">
        <header class="admin-topbar">
            <button type="button" class="admin-menu-btn" aria-label="Open menu"
                onclick="document.body.classList.toggle('sidebar-open')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <h1 class="admin-page-title">@yield('title', 'Dashboard')</h1>

            <div class="admin-user">
                <div class="admin-user-avatar">{{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="admin-user-info">
                    <div class="admin-user-name">{{ auth()->user()->name }}</div>
                    <div class="admin-user-email">{{ auth()->user()->email }}</div>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-light btn-sm">Log out</button>
                </form>
            </div>
        </header>

        <main class="admin-content">
            @if(session('success'))
                <div class="alert alert-success" role="status">{{ session('success') }}</div>
            @endif

            @if($errors->has('sync'))
                <div class="alert alert-error" role="alert">{{ $errors->first('sync') }}</div>
            @elseif($errors->has('languages'))
                <div class="alert alert-error" role="alert">{{ $errors->first('languages') }}</div>
            @elseif($errors->any())
                <div class="alert alert-error" role="alert">Please fix the errors below and try again.</div>
            @endif

            @yield('content')
        </main>
    </div>

    <div class="admin-overlay" onclick="document.body.classList.remove('sidebar-open')"></div>

    <script>
        // Ask before deleting
        document.addEventListener('submit', function (event) {
            const message = event.target.dataset.confirm;
            if (message && !confirm(message)) event.preventDefault();
        });
    </script>
    @stack('scripts')
</body>

</html>
