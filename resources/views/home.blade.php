@extends('layouts.app')

@section('title', 'Home | Department of Land Title Settlement | Sri Lanka')

@section('content')

    {{-- Hero --}}
    @include('partials.hero')

    {{-- Stats Bar --}}
    @include('partials.stats', ['stats' => $stats])

    {{-- Services --}}
    @include('partials.services')

    {{-- News & Events --}}
    @include('partials.news-events', ['news' => collect($news)])

    {{-- Mission & Vision --}}
    @include('partials.mission-vision')

@endsection
