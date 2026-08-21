@extends('layouts.app')

@section('title', 'News & Events | Department of Land Title Settlement | Sri Lanka')

@section('content')

    {{-- Banner --}}
    @include('partials.page-banner', [
        'title' => 'News & Events',
        'subtitle' => 'Latest updates, training programs, and official notices from the Department',
        'showSubnav' => false
    ])

    <div style="background: var(--gray-50); padding-bottom: 2rem;">
        {{-- Includes the existing partial but we wrap it out a bit to fit perfectly --}}
        @include('partials.news-events', ['news' => collect($news)])
    </div>

@endsection