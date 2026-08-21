@extends('layouts.app')

@section('title', 'Services | Department of Land Title Settlement')

@section('content')

    {{-- Banner --}}
    @include('partials.page-banner', [
        'title' => 'Our Services',
        'subtitle' => 'Comprehensive Land Management Solutions',
        'parent' => 'Home',
        'parentUrl' => route('home'),
        'showSubnav' => false
    ])

    <div class="services-page-content">
        <div class="container py-5">
            @include('partials.services')
        </div>
    </div>

@endsection
