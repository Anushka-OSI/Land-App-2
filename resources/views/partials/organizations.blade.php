{{-- Related Organizations Marquee --}}
@php
    $organizationsList = $organizations ?? [
        ['name' => 'Ministry of Land and Land Development', 'logo' => null],
        ['name' => 'Survey Department',                      'logo' => null],
        ['name' => 'Department of Land Title Settlement',    'logo' => null],
        ['name' => 'Government Press',                       'logo' => null],
        ['name' => 'Land Commissioner General\'s Department','logo' => null],
        ['name' => 'Registrar General\'s Department',        'logo' => null],
    ];
@endphp

<section class="orgs-section" id="organizations" aria-label="Related government organizations">
    <div class="container">
        <div class="orgs-header reveal">
            <p class="orgs-label">Related Government Organizations</p>
        </div>
    </div>

    <div class="marquee-wrap" aria-hidden="true">
        <div class="marquee-track" id="marquee-track">
            @foreach($organizationsList as $org)
            <div class="org-card">
                <div class="org-logo">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <span class="org-name">{{ $org['name'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>
