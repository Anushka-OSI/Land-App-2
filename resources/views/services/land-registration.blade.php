@extends('layouts.app')

@section('title', 'Land Settlement | Services | Department of Land Title Settlement')

@section('content')

    {{-- Banner --}}
    @include('partials.page-banner', [
        'title' => 'Land Settlement',
        'subtitle' => 'Determining State vs Private Lands',
        'parent' => 'Services',
        'parentUrl' => route('services'),
        'showSubnav' => false
    ])

    <div class="services-page-content">
        <div class="container py-5">

            {{-- What is Land Settlement/Registration --}}
            <section class="mb-5 reveal" style="margin-bottom: 4rem;">
                <span class="section-label">Overview</span>
                <h2 class="section-title mb-3" style="margin-bottom: 1.5rem;">What is Land Registration / Settlement?</h2>
                <div
                    style="background: var(--green-50); border-radius: var(--radius-lg); padding: 2.5rem; text-align: justify;">
                    <p style="font-size: 1.05rem; color: var(--gray-800); margin: 0;">
                        Land Registration (or Land Settlement) is the formal legal process of demarcating, investigating,
                        and determining the ownership of land parcels. In Sri Lanka, it acts to firmly distinguish between
                        State-owned lands and bona-fide private lands. This process provides absolute certainty by
                        registering the title under the state-guaranteed Title Registration system, culminating in the
                        issuance of a legally binding Title Certificate to the rightful owner.
                    </p>
                </div>
            </section>

            {{-- Why is it necessary & Benefits --}}
            <section class="mb-5 reveal"
                style="margin-bottom: 4rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">

                <div
                    style="background: var(--white); border-radius: var(--radius-lg); padding: 2.5rem; box-shadow: var(--shadow-md);">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                        <span class="badge badge-notice">Necessity</span>
                        <h3
                            style="font-family: var(--font-heading); color: var(--green-800); font-size: 1.5rem; margin: 0;">
                            Why is it Necessary for Sri Lanka?</h3>
                    </div>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                            <svg style="width:20px;height:20px; flex-shrink:0; color:var(--green-600); margin-top:2px;"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span style="color: var(--gray-700); font-size: 0.95rem;">To eliminate historical ambiguities
                                between state reserves, crown lands, and private inheritances.</span>
                        </li>
                        <li style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                            <svg style="width:20px;height:20px; flex-shrink:0; color:var(--green-600); margin-top:2px;"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span style="color: var(--gray-700); font-size: 0.95rem;">To drastically reduce prolonged land
                                disputes and overlapping claims in courts.</span>
                        </li>
                        <li style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                            <svg style="width:20px;height:20px; flex-shrink:0; color:var(--green-600); margin-top:2px;"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span style="color: var(--gray-700); font-size: 0.95rem;">To foster agricultural and economic
                                development by providing secure land tenure to farmers and citizens.</span>
                        </li>
                        <li style="display: flex; gap: 1rem;">
                            <svg style="width:20px;height:20px; flex-shrink:0; color:var(--green-600); margin-top:2px;"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span style="color: var(--gray-700); font-size: 0.95rem;">To modernize the country's land
                                administration utilizing a cadastre-based, map-driven registration system.</span>
                        </li>
                    </ul>
                </div>

                <div
                    style="background: linear-gradient(135deg, var(--green-800), var(--green-900)); border-radius: var(--radius-lg); padding: 2.5rem; box-shadow: var(--shadow-md);">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                        <span class="badge" style="background: var(--gold-500); color: var(--white);">Advantages</span>
                        <h3 style="font-family: var(--font-heading); color: var(--white); font-size: 1.5rem; margin: 0;">
                            Benefits From Land Settlement</h3>
                    </div>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                            <svg style="width:20px;height:20px; flex-shrink:0; color:var(--gold-400); margin-top:2px;"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span style="color: rgba(255,255,255,0.85); font-size: 0.95rem;"><strong>Access to
                                    Finance:</strong> Unambiguous titles make it easier to obtain bank loans and
                                mortgages.</span>
                        </li>
                        <li style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                            <svg style="width:20px;height:20px; flex-shrink:0; color:var(--gold-400); margin-top:2px;"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span style="color: rgba(255,255,255,0.85); font-size: 0.95rem;"><strong>State
                                    Guarantee:</strong> The government legally guarantees the ownership, protecting it
                                against fraud.</span>
                        </li>
                        <li style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                            <svg style="width:20px;height:20px; flex-shrink:0; color:var(--gold-400); margin-top:2px;"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span style="color: rgba(255,255,255,0.85); font-size: 0.95rem;"><strong>Increased
                                    Value:</strong> Settled plots have higher market value and easier
                                transferability.</span>
                        </li>
                        <li style="display: flex; gap: 1rem;">
                            <svg style="width:20px;height:20px; flex-shrink:0; color:var(--gold-400); margin-top:2px;"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span style="color: rgba(255,255,255,0.85); font-size: 0.95rem;"><strong>Peace of Mind:</strong>
                                Permanent resolution of ancestral boundary and ownership disputes.</span>
                        </li>
                    </ul>
                </div>
            </section>

            {{-- Laws Relating --}}
            <section class="mb-5 reveal" style="margin-bottom: 4rem;">
                <div style="text-align: center; margin-bottom: 2rem;">
                    <span class="section-label">Legal Framework</span>
                    <h2 class="section-title">Laws Relating to Land Settlement Work</h2>
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                    <div
                        style="background: var(--white); border: 1px solid var(--gray-200); border-radius: var(--radius-md); padding: 1.5rem; text-align: center; box-shadow: var(--shadow-sm);">
                        <h4
                            style="font-family: var(--font-heading); color: var(--green-800); font-weight: 700; font-size: 1.15rem; margin-bottom: 0.5rem;">
                            Land Settlement Ordinance</h4>
                        <div style="margin-bottom: 0.75rem;"><span class="badge"
                                style="background: var(--gray-200); color: var(--gray-700);">No. 20 of 1931</span></div>
                        <p style="color: var(--gray-600); font-size: 0.88rem; margin: 0; line-height: 1.6;">The overarching
                            legal mechanism for resolving ownership of uncultivated lands and reserving state lands across
                            Sri Lanka.</p>
                    </div>
                    <div
                        style="background: var(--white); border: 1px solid var(--gray-200); border-radius: var(--radius-md); padding: 1.5rem; text-align: center; box-shadow: var(--shadow-sm);">
                        <h4
                            style="font-family: var(--font-heading); color: var(--green-800); font-weight: 700; font-size: 1.15rem; margin-bottom: 0.5rem;">
                            Registration of Title Act</h4>
                        <div style="margin-bottom: 0.75rem;"><span class="badge"
                                style="background: var(--gray-200); color: var(--gray-700);">No. 21 of 1998</span></div>
                        <p style="color: var(--gray-600); font-size: 0.88rem; margin: 0; line-height: 1.6;">Introduced the
                            modern Torrens system (Bim Saviya) providing state-certified, indefeasible titles to landowners.
                        </p>
                    </div>
                    <div
                        style="background: var(--white); border: 1px solid var(--gray-200); border-radius: var(--radius-md); padding: 1.5rem; text-align: center; box-shadow: var(--shadow-sm);">
                        <h4
                            style="font-family: var(--font-heading); color: var(--green-800); font-weight: 700; font-size: 1.15rem; margin-bottom: 0.5rem;">
                            Other Key Regulations</h4>
                        <div style="margin-bottom: 0.75rem;"><span class="badge"
                                style="background: var(--gray-200); color: var(--gray-700);">Various Enactments</span></div>
                        <p style="color: var(--gray-600); font-size: 0.88rem; margin: 0; line-height: 1.6;">Including the
                            Crown Lands Encroachment Ordinance (1840) and Waste Lands Ordinances structurally shaping our
                            historical land policies.</p>
                    </div>
                </div>
            </section>

            {{-- Procedure in Steps --}}
            <section class="service-details-section reveal" style="margin-bottom: 4rem;">
                <div class="section-header-row mb-4">
                    <div>
                        <span class="section-label">Step-by-Step</span>
                        <h2 class="section-title">Procedure of Land Settlement</h2>
                    </div>
                </div>

                <div class="aims-grid-preview mt-4">
                    @foreach($procedure as $step)
                        <div class="aim-mini-card reveal">
                            <div class="aim-mini-num">0{{ $step['step'] }}</div>
                            <h3 class="aim-mini-title">{{ $step['title'] }}</h3>
                            <p class="aim-mini-desc">{{ $step['description'] }}</p>
                            <span class="aim-mini-act">{{ $step['section'] }}</span>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- Partner Organizations --}}
            <section class="reveal"
                style="background: var(--gray-50); border-radius: var(--radius-xl); padding: 3rem; box-shadow: inset 0 2px 10px rgba(0,0,0,0.02);">
                <div
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 3rem; align-items: center;">
                    <div>
                        <span class="section-label">Collaborators</span>
                        <h2 class="section-title" style="margin: 0.5rem 0 1rem 0; font-size: 2rem;">Organizations Assisting
                            the Department</h2>
                        <p style="color: var(--gray-600); font-size: 1.05rem; line-height: 1.6; margin: 0;">
                            The land settlement process requires extensive inter-departmental cooperation. The Department of
                            Land Title Settlement collaborates closely with these key government bodies to ensure accurate
                            surveying, legal governance, field verification, and final publication of settlements.
                        </p>
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 0.75rem;">
                        <div
                            style="background: var(--white); padding: 1rem 1.5rem; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border-left: 4px solid var(--green-600); display: flex; align-items: center;">
                            <h5 style="margin: 0; font-family: var(--font-body); font-weight: 600; color: var(--gray-800);">
                                Department of Surveys</h5>
                        </div>
                        <div
                            style="background: var(--white); padding: 1rem 1.5rem; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border-left: 4px solid var(--gold-500); display: flex; align-items: center;">
                            <h5 style="margin: 0; font-family: var(--font-body); font-weight: 600; color: var(--gray-800);">
                                Offices of the Govt. Agents</h5>
                        </div>
                        <div
                            style="background: var(--white); padding: 1rem 1.5rem; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border-left: 4px solid var(--green-600); display: flex; align-items: center;">
                            <h5 style="margin: 0; font-family: var(--font-body); font-weight: 600; color: var(--gray-800);">
                                Divisional Secretariats</h5>
                        </div>
                        <div
                            style="background: var(--white); padding: 1rem 1.5rem; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border-left: 4px solid var(--gold-500); display: flex; align-items: center;">
                            <h5 style="margin: 0; font-family: var(--font-body); font-weight: 600; color: var(--gray-800);">
                                All District Courts & Fiscal Offices</h5>
                        </div>
                        <div
                            style="background: var(--white); padding: 1rem 1.5rem; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border-left: 4px solid var(--green-800); display: flex; align-items: center;">
                            <h5 style="margin: 0; font-family: var(--font-body); font-weight: 600; color: var(--gray-800);">
                                Department of Govt. Press</h5>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>

@endsection