@extends('layouts.admin')

@section('title', 'Regional Offices')

@section('content')

    <div class="toolbar">
        <form method="GET" class="filters">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search offices, addresses, emails"
                class="form-input">
            <select name="province" class="form-input" onchange="this.form.submit()">
                <option value="">All provinces</option>
                @foreach(\App\Models\RegionalOffice::PROVINCES as $key => $label)
                    <option value="{{ $key }}" @selected(request('province') === $key)>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-light">Filter</button>
        </form>
        <div class="toolbar-actions">
            <a href="{{ route('contact.regional-office') }}" target="_blank" class="btn btn-light">View page ↗</a>
            <a href="{{ route('admin.regional-offices.create', array_filter(['province' => request('province')])) }}"
                class="btn btn-primary">+ Add Office</a>
        </div>
    </div>

    <p class="page-help">District offices listed on <strong>Contact Us → Regional Offices</strong>, grouped by province.
        Each office also appears in the office list of the Contact Us inquiry form.</p>

    <div class="panel table-panel">
        <table class="table">
            <thead>
                <tr>
                    <th>Office</th>
                    <th>Province</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th class="actions-col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($offices as $item)
                    <tr>
                        <td>
                            <a href="{{ route('admin.regional-offices.edit', $item) }}" class="cell-title">{{ $item->name }}</a>
                            @if($item->address)
                                <div class="cell-sub">{{ $item->address }}</div>
                            @endif
                            @include('admin.partials.simple-translation-badges', ['item' => $item, 'field' => 'name'])
                        </td>
                        <td class="nowrap">{{ $item->province_label }}</td>
                        <td class="nowrap">{{ $item->phone ?: '—' }}</td>
                        <td>{{ $item->email ?: '—' }}</td>
                        <td>{{ $item->sort_order }}</td>
                        <td>
                            <span class="badge {{ $item->is_published ? 'badge-replied' : 'badge-muted' }}">
                                {{ $item->is_published ? 'Shown' : 'Hidden' }}
                            </span>
                        </td>
                        <td class="actions-col">
                            <a href="{{ route('admin.regional-offices.edit', $item) }}" class="btn btn-light btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.regional-offices.destroy', $item) }}" class="inline"
                                data-confirm="Delete &quot;{{ $item->name }}&quot;? This cannot be undone.">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty">No regional offices found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
