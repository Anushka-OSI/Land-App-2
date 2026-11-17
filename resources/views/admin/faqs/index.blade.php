@extends('layouts.admin')

@section('title', 'FAQs')

@section('content')

    <div class="toolbar">
        <form method="GET" class="filters">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search questions and answers"
                class="form-input">
            <select name="category" class="form-input" onchange="this.form.submit()">
                <option value="">All categories</option>
                @foreach(\App\Models\Faq::CATEGORIES as $key => $label)
                    <option value="{{ $key }}" @selected(request('category') === $key)>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-light">Filter</button>
        </form>
        <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">+ Add FAQ</a>
    </div>

    <div class="panel table-panel">
        <table class="table">
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Category</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th class="actions-col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faqs as $faq)
                    <tr>
                        <td>
                            <a href="{{ route('admin.faqs.edit', $faq) }}" class="cell-title">{{ $faq->question }}</a>
                            <div class="cell-sub">{{ \Illuminate\Support\Str::limit($faq->answer, 100) }}</div>
                        </td>
                        <td class="nowrap">{{ $faq->category_label }}</td>
                        <td>{{ $faq->sort_order }}</td>
                        <td>
                            <span class="badge {{ $faq->is_published ? 'badge-replied' : 'badge-muted' }}">
                                {{ $faq->is_published ? 'Published' : 'Hidden' }}
                            </span>
                        </td>
                        <td class="actions-col">
                            <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-light btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" class="inline"
                                data-confirm="Delete this FAQ? This cannot be undone.">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty">No FAQs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $faqs->links('pagination::default') }}

@endsection
