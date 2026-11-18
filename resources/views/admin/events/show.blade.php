@extends('layouts.admin')

@section('title', 'View Event')

@section('content')

    <a href="{{ route('admin.events.index') }}" class="back-link">&larr; Back to Events</a>

    <article class="panel message-panel">
        <div class="message-head">
            <div>
                <span class="badge badge-type">Event</span>
            </div>
            <span class="badge {{ $item->is_published ? 'badge-replied' : 'badge-muted' }}">
                {{ $item->is_published ? 'Published' : 'Draft' }}
            </span>
        </div>

        <dl class="message-meta">
            <div>
                <dt>Event date</dt>
                <dd>{{ $item->event_date->format('M j, Y') }}</dd>
            </div>
            <div>
                <dt>Languages</dt>
                <dd>@include('admin.partials.language-badges', ['item' => $item])</dd>
            </div>
            <div>
                <dt>Photos</dt>
                <dd>{{ $item->images->count() }}</dd>
            </div>
            <div>
                <dt>Last updated</dt>
                <dd>{{ $item->updated_at?->format('M j, Y g:i A') ?? '—' }}</dd>
            </div>
        </dl>

        @include('admin.partials.content-view', ['item' => $item, 'withPhotos' => true])

        <div class="form-actions">
            <a href="{{ route('admin.events.edit', $item) }}" class="btn btn-primary">Edit</a>
            @if($item->is_published)
                <a href="{{ route('events.show', $item) }}" target="_blank" class="btn btn-light">View on website ↗</a>
            @endif
            <form method="POST" action="{{ route('admin.events.destroy', $item) }}" class="inline"
                data-confirm="Delete &quot;{{ $item->title }}&quot; and all its photos? This cannot be undone.">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </article>

@endsection
