{{--
    Homepage: all offices on a map of Sri Lanka as red dots, with the office counts.
    Needs $officeMap = ['offices' => OfficeLocations::all(), 'headCount' => int, 'regionalCount' => int].
    Clicking a dot (or a name in the list) opens that office on Contact Us → Head Office / Regional Offices.
--}}
@php
    $offices = $officeMap['offices'];
    $headCount = $officeMap['headCount'];
    $regionalCount = $officeMap['regionalCount'];
@endphp

@include('partials.leaflet')

<section class="office-map-section" id="our-offices" aria-labelledby="our-offices-title">
    <div class="container">
        <div class="office-map-layout" data-office-map data-go-label="{{ __('View contact details') }}">
            <script type="application/json">@json($offices)</script>

            <div class="office-map-info reveal">
                <span class="section-label">{{ __('Island-Wide Network') }}</span>
                <h2 class="section-title" id="our-offices-title">{{ __('Our Offices') }}</h2>
                <p class="section-subtitle">{{ __('Find the Head Office and the regional offices near you. Click a red dot to see the office\'s contact details.') }}</p>

                <div class="office-counts">
                    <a href="{{ route('contact.head-office') }}#head-office" class="office-count">
                        <span class="office-count-value">{{ $headCount }}</span>
                        <span class="office-count-label">{{ __('Head Office') }}</span>
                    </a>
                    <a href="{{ route('contact.regional-office') }}" class="office-count">
                        <span class="office-count-value">{{ $regionalCount }}</span>
                        <span class="office-count-label">{{ __('Regional Offices') }}</span>
                    </a>
                    <div class="office-count office-count--total">
                        <span class="office-count-value">{{ $headCount + $regionalCount }}</span>
                        <span class="office-count-label">{{ __('Total Offices') }}</span>
                    </div>
                </div>

                <ul class="office-legend" aria-hidden="true">
                    <li><span class="office-legend-dot office-legend-dot--head"></span>{{ __('Head Office') }}</li>
                    <li><span class="office-legend-dot"></span>{{ __('Regional Office') }}</li>
                </ul>
            </div>

            <div class="office-map-frame reveal">
                <div class="office-map-canvas" role="region" aria-label="{{ __('Map of our offices in Sri Lanka') }}"></div>
                @if(empty($offices))
                    <p class="office-map-empty">{{ __('Office locations will be shown here soon.') }}</p>
                @endif
            </div>

            {{-- Same offices as a list (keyboard / screen readers, and for finding an office by name) --}}
            @if(!empty($offices))
                <details class="office-list reveal">
                    <summary>{{ __('List of offices') }} ({{ count($offices) }})</summary>
                    <ul>
                        @foreach($offices as $i => $office)
                            <li>
                                <a href="{{ $office['url'] }}" data-office-index="{{ $i }}">
                                    <span class="office-list-dot {{ $office['type'] === 'head' ? 'office-list-dot--head' : '' }}" aria-hidden="true"></span>
                                    {{ $office['name'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </details>
            @endif
        </div>
    </div>
</section>
