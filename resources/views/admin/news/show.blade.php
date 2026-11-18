@extends('layouts.admin')

@section('title', 'View News / Notice')

@section('content')

    <a href="{{ route('admin.news.index') }}" class="back-link">&larr; Back to News &amp; Notices</a>

    <article class="panel message-panel">
        <div class="message-head">
            <div>
                <span class="badge badge-type">News / Notice</span>
            </div>
            <span class="badge {{ $item->is_published ? 'badge-replied' : 'badge-muted' }}">
                {{ $item->is_published ? 'Published' : 'Draft' }}
            </span>
        </div>

        <dl class="message-meta">
            <div>
                <dt>Date</dt>
                <dd>{{ $item->published_at->format('M j, Y') }}</dd>
            </div>
            <div>
                <dt>Languages</dt>
                <dd>@include('admin.partials.language-badges', ['item' => $item])</dd>
            </div>
            <div>
                <dt>Last updated</dt>
                <dd>{{ $item->updated_at?->format('M j, Y g:i A') ?? '—' }}</dd>
            </div>
        </dl>

        @include('admin.partials.content-view', ['item' => $item])

        <section class="form-group" style="margin-top:1.5rem;">
            <h2 class="form-legend">Documents ({{ $item->documents->count() }})</h2>
            @if($item->documents->isEmpty())
                <p class="hint">No documents attached. Add them with Edit.</p>
            @else
                <ul class="doc-view-list">
                    @foreach($item->documents as $document)
                        <li>
                            <span class="doc-ext doc-ext--{{ $document->extension }}" aria-hidden="true">{{ strtoupper($document->extension) }}</span>
                            <span class="doc-view-name">
                                <strong>{{ $document->name }}</strong>
                                <span class="cell-sub">{{ $document->languageLabel() }} · {{ $document->sizeLabel() }} · {{ $document->original_name }}</span>
                            </span>
                            @if($document->canView())
                                <a href="{{ $document->url() }}" target="_blank" rel="noopener" class="btn btn-light btn-sm">View</a>
                            @endif
                            <a href="{{ $document->url(true) }}" class="btn btn-light btn-sm">Download</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <div class="form-actions">
            <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-primary">Edit</a>
            @if($item->is_published)
                <a href="{{ route('news.show', $item) }}" target="_blank" class="btn btn-light">View on website ↗</a>
            @endif
            <form method="POST" action="{{ route('admin.news.destroy', $item) }}" class="inline"
                data-confirm="Delete &quot;{{ $item->title }}&quot;? This cannot be undone.">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </article>

@endsection
