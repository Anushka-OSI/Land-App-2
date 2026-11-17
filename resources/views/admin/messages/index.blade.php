@extends('layouts.admin')

@section('title', 'Messages')

@section('content')

    <div class="toolbar">
        <form method="GET" class="filters">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search name, email or text"
                class="form-input">
            <select name="type" class="form-input" onchange="this.form.submit()">
                <option value="">All types</option>
                @foreach(\App\Models\Message::TYPES as $key => $label)
                    <option value="{{ $key }}" @selected(request('type') === $key)>{{ $label }}</option>
                @endforeach
            </select>
            <select name="status" class="form-input" onchange="this.form.submit()">
                <option value="">All statuses</option>
                @foreach(\App\Models\Message::STATUSES as $key => $label)
                    <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-light">Filter</button>
        </form>
    </div>

    <div class="panel table-panel">
        <table class="table">
            <thead>
                <tr>
                    <th>From</th>
                    <th>Message</th>
                    <th>Type</th>
                    <th>Received</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $message)
                    <tr class="{{ $message->status === 'new' ? 'row-unread' : '' }}">
                        <td>
                            <div class="cell-title">{{ $message->name }}</div>
                            <div class="cell-sub">{{ $message->email }}</div>
                        </td>
                        <td>
                            <a href="{{ route('admin.messages.show', $message) }}" class="cell-title">
                                {{ $message->subject ?: \Illuminate\Support\Str::limit($message->body, 70) }}
                            </a>
                            @if($message->subject)
                                <div class="cell-sub">{{ \Illuminate\Support\Str::limit($message->body, 90) }}</div>
                            @endif
                        </td>
                        <td class="nowrap">{{ $message->type_label }}</td>
                        <td class="nowrap" title="{{ $message->created_at }}">{{ $message->created_at->diffForHumans() }}
                        </td>
                        <td><span class="badge badge-{{ $message->status }}">{{ $message->status_label }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty">No messages found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $messages->links('pagination::default') }}

@endsection
