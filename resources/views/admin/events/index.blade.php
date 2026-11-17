@extends('layouts.admin')

@section('title', 'Events')

@section('content')

    <div class="toolbar">
        <form method="GET" class="filters">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search titles" class="form-input">
            @include('admin.partials.language-filter')
            <button type="submit" class="btn btn-light">Filter</button>
        </form>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">+ Add Event</a>
    </div>

    <div class="panel table-panel">
        <table class="table">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Languages</th>
                    <th>Date</th>
                    <th>Photos</th>
                    <th>Status</th>
                    <th class="actions-col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $item)
                    <tr>
                        <td lang="{{ $item->displayLanguage() }}">
                            <div class="cell-with-thumb">
                                @if($item->images->isNotEmpty())
                                    <img src="{{ $item->images->first()->url }}" alt="" class="cell-thumb">
                                @else
                                    <span class="cell-thumb placeholder" aria-hidden="true"></span>
                                @endif
                                <div>
                                    <a href="{{ route('admin.events.edit', $item) }}" class="cell-title">{{ $item->title }}</a>
                                    <div class="cell-sub">{{ \Illuminate\Support\Str::limit($item->excerpt, 80) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="nowrap">@include('admin.partials.language-badges', ['item' => $item])</td>
                        <td class="nowrap">{{ $item->event_date->format('M j, Y') }}</td>
                        <td class="nowrap">
                            @php $perLang = $item->images->countBy('language'); @endphp
                            @if($perLang->isEmpty())
                                —
                            @else
                                <span class="photo-counts">
                                    @foreach(\App\Support\Languages::ALL as $code => $lang)
                                        @if($perLang->get($code))
                                            <span title="{{ $lang['label'] }} photos"><span lang="{{ $code }}">{{ $lang['short'] }}</span> {{ $perLang->get($code) }}</span>
                                        @endif
                                    @endforeach
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $item->is_published ? 'badge-replied' : 'badge-muted' }}">
                                {{ $item->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="actions-col">
                            <a href="{{ route('admin.events.edit', $item) }}" class="btn btn-light btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.events.destroy', $item) }}" class="inline"
                                data-confirm="Delete &quot;{{ $item->title }}&quot; and all its photos? This cannot be undone.">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty">No events found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $events->links('pagination::default') }}

@endsection
