@extends('layouts.app')

@section('title', __('Services | Department of Land Title Settlement'))

@section('content')

    {{-- Banner --}}
    @include('partials.page-banner', [
        'title' => __('Our Services'),
        'subtitle' => __('Comprehensive Land Management Solutions'),
        'parent' => __('Home'),
        'parentUrl' => route('home'),
        'showSubnav' => false
    ])

    <div class="services-page-content">
        <div class="container py-5">
            @include('partials.services')
        </div>
    </div>

@endsection
