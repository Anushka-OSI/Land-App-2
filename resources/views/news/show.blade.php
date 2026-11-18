@extends('layouts.app')

@php $shown = $item->displayLanguage($lang); @endphp

@section('title', __(':title | News & Notices | Department of Land Title Settlement', ['title' => $item->t('title', $lang)]))

@section('content')

    @include('partials.page-banner', [
        'title' => __('News & Notices'),
        'subtitle' => __('Official updates and notices from the Department'),
        'showSubnav' => false
    ])

    <section class="article-section">
        <div class="container article-container">
            <div class="article-topbar">
                <a href="{{ route('news') }}" class="article-back">&larr; {{ __('Back to News & Events') }}</a>
                @if(count($item->availableLanguages()) > 1)
                    @include('partials.content-language-switch', [
                        'lang' => $shown,
                        'url' => route('news.show', $item),
                        'available' => $item->availableLanguages(),
                    ])
                @endif
            </div>

            <article class="article" lang="{{ $shown }}">
                <div class="article-meta" lang="{{ app()->getLocale() }}">
                    <span class="badge badge-news">{{ __('News & Notices') }}</span>
                    <time datetime="{{ $item->published_at->format('Y-m-d') }}">{{ $item->published_at->translatedFormat('F j, Y') }}</time>
                </div>

                @if($shown !== $lang)
                    <p class="article-notice" lang="{{ app()->getLocale() }}">{{ __('This item is not available in :language. Showing :shown.', ['language' => \App\Support\Languages::native($lang), 'shown' => \App\Support\Languages::native($shown)]) }}</p>
                @endif

                <h1 class="article-title">{{ $item->t('title', $lang) }}</h1>
                <p class="article-lead">{{ $item->t('excerpt', $lang) }}</p>

                @if($item->t('body', $lang))
                    <div class="rich-content">{!! $item->t('body', $lang) !!}</div>
                @endif

                {{-- Documents to view / download --}}
                @php $documents = $item->documentsFor($shown); @endphp
                @if($documents->isNotEmpty())
                    <section class="article-docs" lang="{{ app()->getLocale() }}" aria-labelledby="article-docs-title">
                        <h2 class="article-docs-title" id="article-docs-title">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                            {{ __('Documents') }}
                        </h2>
                        <ul class="doc-cards">
                            @foreach($documents as $document)
                                <li class="doc-card">
                                    <span class="doc-icon doc-icon--{{ $document->extension }}" aria-hidden="true">{{ strtoupper($document->extension) }}</span>
                                    <div class="doc-info">
                                        <span class="doc-name" @if($document->language) lang="{{ $document->language }}" @endif>{{ $document->name }}</span>
                                        <span class="doc-meta">
                                            {{ $document->typeLabel() }} · {{ $document->sizeLabel() }}
                                            @if($document->language)
                                                · {{ \App\Support\Languages::native($document->language) }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="doc-actions">
                                        @if($document->canView())
                                            <a href="{{ $document->url() }}" target="_blank" rel="noopener" class="doc-btn doc-btn--view"
                                                aria-label="{{ __('View') }}: {{ $document->name }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                {{ __('View') }}
                                            </a>
                                        @endif
                                        <a href="{{ $document->url(true) }}" class="doc-btn doc-btn--download" download
                                            aria-label="{{ __('Download') }}: {{ $document->name }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            {{ __('Download') }}
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endif
            </article>

            @if($related->isNotEmpty())
                <aside class="article-related" aria-label="{{ __('More news and notices') }}">
                    <h2>{{ __('More News & Notices') }}</h2>
                    <ul>
                        @foreach($related as $other)
                            <li lang="{{ $other->displayLanguage($lang) }}">
                                <a href="{{ route('news.show', $other) }}">{{ $other->t('title', $lang) }}</a>
                                <time lang="{{ app()->getLocale() }}">{{ $other->published_at->translatedFormat('M j, Y') }}</time>
                            </li>
                        @endforeach
                    </ul>
                </aside>
            @endif
        </div>
    </section>

@endsection
