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
