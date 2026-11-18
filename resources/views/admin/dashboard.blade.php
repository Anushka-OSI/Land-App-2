@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <p class="page-intro">Welcome back, {{ auth()->user()->name }}. Here's an overview of the website.</p>

    {{-- Stat cards --}}
    <div class="stat-grid">
        <a href="{{ route('admin.messages.index', ['status' => 'new']) }}" class="stat-card accent">
            <div class="stat-value">{{ $stats['messages_new'] }}</div>
            <div class="stat-label">New messages</div>
            <div class="stat-sub">{{ $stats['inquiries'] }} inquiries · {{ $stats['questions'] }} FAQ questions</div>
        </a>
        <a href="{{ route('admin.news.index') }}" class="stat-card">
            <div class="stat-value">{{ $stats['news'] }}</div>
            <div class="stat-label">News & Notices</div>
            <div class="stat-sub">{{ $stats['news_published'] }} published</div>
        </a>
        <a href="{{ route('admin.events.index') }}" class="stat-card">
            <div class="stat-value">{{ $stats['events'] }}</div>
            <div class="stat-label">Events</div>
            <div class="stat-sub">{{ $stats['events_published'] }} published</div>
        </a>
        <a href="{{ route('admin.faqs.index') }}" class="stat-card">
            <div class="stat-value">{{ $stats['faqs'] }}</div>
            <div class="stat-label">FAQs</div>
            <div class="stat-sub">{{ $stats['faqs_hidden'] }} hidden</div>
        </a>
    </div>

    {{-- Quick actions --}}
    <div class="quick-actions">
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">+ Add News / Notice</a>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">+ Add Event</a>
        <a href="{{ route('admin.calendar.create') }}" class="btn btn-light">+ Add Calendar Event</a>
        <a href="{{ route('admin.faqs.create') }}" class="btn btn-light">+ Add FAQ</a>
        <a href="{{ route('admin.messages.index') }}" class="btn btn-light">View Messages</a>
    </div>

    <div class="dash-grid">

        {{-- Recent messages --}}
        <section class="panel dash-span">
            <div class="panel-header">
                <h2>Recent Messages</h2>
                <a href="{{ route('admin.messages.index') }}" class="panel-link">View all</a>
            </div>
            @forelse($recentMessages as $message)
                <a href="{{ route('admin.messages.show', $message) }}" class="list-row">
                    <div class="list-main">
                        <div class="list-title">
                            {{ $message->subject ?: \Illuminate\Support\Str::limit($message->body, 60) }}
                        </div>
                        <div class="list-sub">{{ $message->name }} · {{ $message->type_label }} ·
                            {{ $message->created_at->diffForHumans() }}</div>
                    </div>
                    <span class="badge badge-{{ $message->status }}">{{ $message->status_label }}</span>
                </a>
            @empty
                <p class="empty">No messages yet. Inquiries and FAQ questions from the website will appear here.</p>
            @endforelse
        </section>

        {{-- Recent news & notices --}}
        <section class="panel">
            <div class="panel-header">
                <h2>Latest News & Notices</h2>
                <a href="{{ route('admin.news.index') }}" class="panel-link">Manage</a>
            </div>
            @forelse($recentNews as $item)
                <a href="{{ route('admin.news.show', $item) }}" class="list-row">
                    <div class="list-main" lang="{{ $item->displayLanguage() }}">
                        <div class="list-title">{{ $item->title }}</div>
                        <div class="list-sub" lang="en">{{ collect($item->availableLanguages())->map(fn ($l) => \App\Support\Languages::native($l))->implode(" / ") }} · {{ $item->published_at->format('M j, Y') }}
                        </div>
                    </div>
                    <span class="badge {{ $item->is_published ? 'badge-replied' : 'badge-muted' }}">
                        {{ $item->is_published ? 'Published' : 'Draft' }}
                    </span>
                </a>
            @empty
                <p class="empty">No news or notices yet.</p>
            @endforelse
        </section>

        {{-- Recent events --}}
        <section class="panel">
            <div class="panel-header">
                <h2>Latest Events</h2>
                <a href="{{ route('admin.events.index') }}" class="panel-link">Manage</a>
            </div>
            @forelse($recentEvents as $item)
                <a href="{{ route('admin.events.show', $item) }}" class="list-row">
                    <div class="list-main" lang="{{ $item->displayLanguage() }}">
                        <div class="list-title">{{ $item->title }}</div>
                        <div class="list-sub" lang="en">{{ collect($item->availableLanguages())->map(fn ($l) => \App\Support\Languages::native($l))->implode(" / ") }} · {{ $item->event_date->format('M j, Y') }}
                            · {{ $item->images_count }} {{ \Illuminate\Support\Str::plural('photo', $item->images_count) }}
                        </div>
                    </div>
                    <span class="badge {{ $item->is_published ? 'badge-replied' : 'badge-muted' }}">
                        {{ $item->is_published ? 'Published' : 'Draft' }}
                    </span>
                </a>
            @empty
                <p class="empty">No events yet.</p>
            @endforelse
        </section>

    </div>

@endsection
