@extends('layouts.app')

@section('title', 'Home | Department of Land Title Settlement | Sri Lanka')

@section('content')

    {{-- Hero --}}
    @include('partials.hero')

    {{-- Stats Bar --}}
    @include('partials.stats', ['stats' => $stats])

    {{-- Latest News Slideshow --}}
    @include('partials.latest-news-slideshow')

    {{-- Services --}}
    @include('partials.services')


    {{-- Mission & Vision --}}
    @include('partials.mission-vision')

@endsection