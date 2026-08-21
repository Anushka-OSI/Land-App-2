@extends('layouts.app')

@section('title', 'Title Registration | Services | Department of Land Title Settlement')

@section('content')

    {{-- Banner --}}
    @include('partials.page-banner', [
        'title' => 'Title Registration',
        'subtitle' => 'Secure and Indefeasible Titles for Every Land Parcel',
        'parent' => 'Services',
        'parentUrl' => route('services'),
        'showSubnav' => false
    ])

    <div class="services-page-content">
        <div class="container py-5">

            {{-- 1. Land Management & Its Benefits --}}
            <section class="about-narrative-section reveal mb-5">
                <div class="narrative-box">
                    <div class="narrative-header">
                        <span class="section-label">Foundation</span>
                        <h2 class="section-title">What is Land Management..?</h2>
                    </div>
                    <div class="narrative-body">
                        <p>
                            <strong>Land management</strong> is the process of managing the use and development of land
                            resources. It encompasses all activities associated with the management of land and natural
                            resources that are required to fulfill human needs while maintaining an ecological balance.
                        </p>
                        <p>
                            Effective land management brings numerous benefits, including:
                        </p>
                        <ul style="list-style: disc; margin-left: 20px; color: #4b5563; margin-bottom: 20px;">
                            <li><strong>Economic Growth:</strong> Facilitates investment and development by providing secure
                                land tenure.</li>
                            <li><strong>Environmental Sustainability:</strong> Promotes responsible land use, conservation
                                of natural resources, and mitigates environmental degradation.</li>
                            <li><strong>Social Equity:</strong> Ensures fair distribution of land resources and protects the
                                rights of vulnerable communities.</li>
                            <li><strong>Dispute Reduction:</strong> Minimizes conflicts over land boundaries and ownership
                                through clear documentation and demarcations.</li>
                        </ul>
                    </div>
                </div>
            </section>

            {{-- 2. Land Title Registration & Its Benefits --}}
            <section class="about-narrative-section reveal mb-5">
                <div class="narrative-box" style="border-top: 4px solid #10b981;">
                    <div class="narrative-header">
                        <span class="section-label">Security</span>
                        <h2 class="section-title">What is Land Title Registration..?</h2>
                    </div>
                    <div class="narrative-body">
                        <p>
                            <strong>Land Title Registration</strong> is a state-guaranteed system where the government
                            officially records and guarantees land ownership. Unlike traditional deed registration (which
                            only records transactions), title registration provides an indefeasible right to the land,
                            officially endorsed by the state.
                        </p>
                        <p>Key Benefits of Title Registration:</p>
                        <ul style="list-style: disc; margin-left: 20px; color: #4b5563; margin-bottom: 20px;">
                            <li><strong>Absolute Security:</strong> Ownership is guaranteed by the government, protecting
                                landowners from fraudulent claims.</li>
                            <li><strong>Ease of Transactions:</strong> Buying, selling, and transferring land becomes
                                faster, cheaper, and more transparent.</li>
                            <li><strong>Access to Finance:</strong> Banks and financial institutions readily accept
                                registered titles as collateral for loans and mortgages.</li>
                            <li><strong>Elimination of Litigation:</strong> Clearly defined boundaries and state-backed
                                ownership significantly reduce protracted legal battles over land.</li>
                        </ul>
                    </div>
                </div>
            </section>

            {{-- 3. The Title Registration Process --}}
            <section class="service-details-section mb-5">
                <div class="section-header-row mb-4">
                    <div>
                        <span class="section-label">Registration of Title Act No. 21 of 1998</span>
                        <h2 class="section-title">Title Registration Process -></h2>
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

            {{-- 4. Bimsaviya Programme --}}
            <section class="about-narrative-section reveal mb-5">
                <div class="narrative-box" style="border-top: 4px solid #f59e0b;">
                    <div class="narrative-header">
                        <span class="section-label">National Initiative</span>
                        <h2 class="section-title">The Bimsaviya Programme</h2>
                    </div>
                    <div class="narrative-body">
                        <div class="bimsaviya-image-container mb-4 text-center">
                            <img src="{{ asset('images/bimsaviya.jpg') }}" alt="Bimsaviya Programme"
                                class="img-fluid rounded shadow-sm"
                                style="max-height: 1000px; width: 100%; object-fit: cover;">
                        </div>
                        <div class="mb-4">
                            <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin-bottom: 10px;">History
                                of the Programme</h3>
                            <p>
                                The "Bimsaviya" programme was initiated to resolve the long-standing complexities and
                                inadequacies of the traditional deed registration system in Sri Lanka. Recognizing the
                                urgent need for a secure and efficient land market, the government enacted the
                                <strong>Registration of Title Act No. 21 of 1998</strong>. The Bimsaviya programme was
                                subsequently launched as the national operative mechanism to systematically survey,
                                investigate, and convert all land titles across the island into state-guaranteed
                                certificates of title.


                            </p>
                        </div>

                        <div>
                            <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin-bottom: 10px;">Procedure</h3>
                            <p>
                                Bimsaviya operates through a coordinated effort among several critical government
                                departments (including the Survey Department, Land Settlement Department, and Registrar
                                General's Department). The simplified procedure involves:
                            </p>
                            <ul style="list-style: decimal; margin-left: 20px; color: #4b5563;">
                                <li class="mb-2"><strong>Declaration & Planning:</strong> An area is officially gazetted for
                                    title registration.</li>
                                <li class="mb-2"><strong>Cadastral Surveying:</strong> The Survey Department creates precise
                                    digital maps of every land parcel within the targeted area.</li>
                                <li class="mb-2"><strong>Claim Investigation:</strong> Landowners submit their claims.
                                    Settlement Officers investigate these claims on the ground ensuring that documents match
                                    the physical boundaries.</li>
                                <li class="mb-2"><strong>Determination:</strong> A formal legal determination is made by the
                                    Commissioner, granting a 1st Class (Absolute) or 2nd Class title based on the strength
                                    of the evidence.</li>
                                <li class="mb-2"><strong>Certification:</strong> The final title is registered and an
                                    indefeasible Title Certificate (Bimsaviya Certificate) is issued to the landowner.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>

@endsection