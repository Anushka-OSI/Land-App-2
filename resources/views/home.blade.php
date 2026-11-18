@extends('layouts.app')

@section('title', __('Home | Department of Land Title Settlement | Sri Lanka'))

@section('content')

    {{-- Hero --}}
    @include('partials.hero')

    {{-- Stats Bar --}}
    @include('partials.stats', ['stats' => $stats])

    {{-- Latest News Slideshow --}}
    @include('partials.latest-news-slideshow')

    {{-- Our Offices: Head Office and regional offices on a map (Admin → Head Office / Regional Offices) --}}
    @include('partials.office-map', ['officeMap' => $officeMap])

    {{-- Services --}}
    @include('partials.services')

    {{-- Our Purpose --}}
    @include('partials.mission-vision')

@endsection