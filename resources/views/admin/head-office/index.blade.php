@extends('layouts.admin')

@section('title', 'Head Office')

@section('content')

    <div class="toolbar">
        <form method="GET" class="filters">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search divisions, officers, emails"
                class="form-input">
            <button type="submit" class="btn btn-light">Search</button>
        </form>
        <div class="toolbar-actions">
            <a href="{{ route('contact.head-office') }}" target="_blank" class="btn btn-light">View page ↗</a>
            <a href="{{ route('admin.head-office.create') }}" class="btn btn-primary">+ Add Division</a>
        </div>
    </div>

    {{-- Head Office name, address and general contact details --}}
    @php $details = \App\Support\HeadOfficeDetails::all(); @endphp
    <div class="panel details-panel">
        <div class="details-panel-head">
            <h3 class="panel-subtitle">Office details</h3>
            <a href="{{ route('admin.head-office-details.edit') }}" class="btn btn-light btn-sm">
                {{ \App\Support\HeadOfficeDetails::isFilled() ? 'Edit details' : '+ Add details' }}</a>
        </div>
        @if(\App\Support\HeadOfficeDetails::isFilled())
            <dl class="message-meta">
                <div><dt>Name</dt><dd>{{ $details['name_en'] ?: '—' }}</dd></div>
                <div><dt>Address</dt><dd>{{ $details['address_en'] ?: '—' }}</dd></div>
                <div><dt>Phone / Fax</dt><dd>{{ $details['phone'] ?: '—' }} / {{ $details['fax'] ?: '—' }}</dd></div>
                <div><dt>Email</dt><dd>{{ $details['email'] ?: '—' }}</dd></div>
                <div><dt>Office hours</dt><dd>{{ $details['hours_en'] ?: '—' }}</dd></div>
                <div>
                    <dt>Map location</dt>
                    <dd>
                        @if($location = \App\Support\HeadOfficeDetails::location())
                            <span class="badge badge-replied">Set</span>
                            {{ number_format($location[0], 5) }}, {{ number_format($location[1], 5) }}
                        @else
                            <span class="badge badge-new">Not set</span>
                            <a href="{{ route('admin.head-office-details.edit') }}#latitude">Add it</a> – needed for the maps on the website
                        @endif
                    </dd>
                </div>
            </dl>
        @else
            <p class="view-empty">Not added yet – the address box on the Head Office page and the contact boxes on the
                Contact Us page stay hidden until you add them.</p>
        @endif
    </div>

    <p class="page-help">Divisions and officers listed on <strong>Contact Us → Head Office</strong>, in display order.
        Each division also appears in the office list of the Contact Us inquiry form.</p>

    <div class="panel table-panel">
        <table class="table">
            <thead>
                <tr>
                    <th>Division / Section</th>
                    <th>Officer</th>
                    <th>Phone / Ext.</th>
                    <th>Email</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th class="actions-col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($divisions as $item)
                    <tr>
                        <td>
                            <a href="{{ route('admin.head-office.edit', $item) }}" class="cell-title">{{ $item->division }}</a>
                            @include('admin.partials.simple-translation-badges', ['item' => $item, 'field' => 'division'])
                        </td>
                        <td>
                            {{ $item->officer ?: '—' }}
                            @if($item->position)
                                <div class="cell-sub">{{ $item->position }}</div>
                            @endif
                        </td>
                        <td class="nowrap">
                            {{ $item->phone ?: '—' }}
                            @if($item->extension)
                                <div class="cell-sub">Ext. {{ $item->extension }}</div>
                            @endif
                        </td>
                        <td>{{ $item->email ?: '—' }}</td>
                        <td>{{ $item->sort_order }}</td>
                        <td>
                            <span class="badge {{ $item->is_published ? 'badge-replied' : 'badge-muted' }}">
                                {{ $item->is_published ? 'Shown' : 'Hidden' }}
                            </span>
                        </td>
                        <td class="actions-col">
                            <a href="{{ route('admin.head-office.edit', $item) }}" class="btn btn-light btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.head-office.destroy', $item) }}" class="inline"
                                data-confirm="Delete &quot;{{ $item->division }}&quot;? This cannot be undone.">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty">No divisions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
