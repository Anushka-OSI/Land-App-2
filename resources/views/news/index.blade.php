@extends('layouts.app')

@section('title', __('News & Events | Department of Land Title Settlement | Sri Lanka'))

@section('content')

    {{-- Banner --}}
    @include('partials.page-banner', [
        'title' => __('News & Events'),
        'subtitle' => __('Latest updates, events, and official notices from the Department'),
        'showSubnav' => false
    ])

    <div style="background: var(--gray-50); padding-bottom: 2rem;">
        @include('partials.news-events', ['news' => $news, 'events' => $events, 'lang' => $lang])
    </div>

@endsection
