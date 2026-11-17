@extends('layouts.admin')

@section('title', $item->exists ? 'Edit News / Notice' : 'Add News / Notice')

@section('content')

    <a href="{{ route('admin.news.index') }}" class="back-link">&larr; Back to News &amp; Notices</a>

    <form method="POST" action="{{ $item->exists ? route('admin.news.update', $item) : route('admin.news.store') }}"
        class="panel form-panel" novalidate>
        @csrf
        @if($item->exists)
            @method('PUT')
        @endif

        <div class="form-group form-narrow">
            <label for="published_at">Date</label>
            <input type="date" id="published_at" name="published_at"
                value="{{ old('published_at', $item->published_at?->format('Y-m-d')) }}"
                class="form-input @error('published_at') is-invalid @enderror">
            @error('published_at') <small class="form-error">{{ $message }}</small> @enderror
        </div>

        @include('admin.partials.translation-tabs', ['item' => $item])

        @include('admin.partials.publish-options', ['item' => $item])

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">{{ $item->exists ? 'Save Changes' : 'Create' }}</button>
            <a href="{{ route('admin.news.index') }}" class="btn btn-light">Cancel</a>
            @if($item->exists && $item->is_published)
                <a href="{{ route('news.show', $item) }}" target="_blank" class="btn btn-light">View on website ↗</a>
            @endif
        </div>
    </form>

@endsection
