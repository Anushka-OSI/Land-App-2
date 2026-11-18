@extends('layouts.admin')

@section('title', $item->exists ? 'Edit News / Notice' : 'Add News / Notice')

@section('content')

    <a href="{{ route('admin.news.index') }}" class="back-link">&larr; Back to News &amp; Notices</a>

    @if(request()->boolean('upload_too_large'))
        <div class="alert alert-error" role="alert">
            The documents were too large to upload in one save (the server accepts up to
            {{ number_format(\App\Models\Event::serverUploadLimit() / 1024 / 1024) }} MB at a time), so nothing was saved.
            Please save with fewer documents, then edit the item to add the rest.
        </div>
    @endif

    <form method="POST" action="{{ $item->exists ? route('admin.news.update', $item) : route('admin.news.store') }}"
        enctype="multipart/form-data" class="panel form-panel" novalidate>
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

        {{-- Documents for visitors to view / download (PDF, Word, Excel …) --}}
        @include('admin.news.partials.documents', ['item' => $item])

        @include('admin.partials.publish-options', ['item' => $item])

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">{{ $item->exists ? 'Save Changes' : 'Create' }}</button>
            <a href="{{ $item->exists ? route('admin.news.show', $item) : route('admin.news.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </form>

@endsection
