@extends('layouts.admin')

@section('title', 'News & Notices')

@section('content')

    <div class="toolbar">
        <form method="GET" class="filters">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search titles" class="form-input">
            @include('admin.partials.language-filter')
            <button type="submit" class="btn btn-light">Filter</button>
        </form>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">+ Add News / Notice</a>
    </div>

    <div class="panel table-panel">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Languages</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th class="actions-col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $item)
                    <tr>
                        <td lang="{{ $item->displayLanguage() }}">
                            <a href="{{ route('admin.news.edit', $item) }}" class="cell-title">{{ $item->title }}</a>
                            <div class="cell-sub">{{ \Illuminate\Support\Str::limit($item->excerpt, 90) }}</div>
                        </td>
                        <td class="nowrap">@include('admin.partials.language-badges', ['item' => $item])</td>
                        <td class="nowrap">{{ $item->published_at->format('M j, Y') }}</td>
                        <td>
                            <span class="badge {{ $item->is_published ? 'badge-replied' : 'badge-muted' }}">
                                {{ $item->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="actions-col">
                            <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-light btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.news.destroy', $item) }}" class="inline"
                                data-confirm="Delete &quot;{{ $item->title }}&quot;? This cannot be undone.">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty">No news or notices found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $news->links('pagination::default') }}

@endsection
