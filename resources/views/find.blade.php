@extends('layouts.app')

@section('title', 'Find Settlement | Department of Land Title Settlement')

@section('content')

    {{-- Banner --}}
    @include('partials.page-banner', [
        'title' => 'Find Land Settlement',
        'subtitle' => 'Search the national registry for your land settlement records and title status',
        'showSubnav' => false
    ])

    <div class="find-page-content" style="background: var(--gray-50); min-height: 70vh; padding: 4rem 0;">
        <div class="container">

            <div style="max-width: 800px; margin: 0 auto;">

                {{-- Search Form Card --}}
                <div
                    style="background: var(--white); border-radius: var(--radius-xl); padding: 3rem; box-shadow: var(--shadow-lg); position: relative; overflow: hidden; margin-bottom: 3rem;">

                    <div
                        style="position: absolute; top: 0; left: 0; right: 0; height: 6px; background: linear-gradient(90deg, var(--green-600), var(--gold-500));">
                    </div>

                    <div style="text-align: center; margin-bottom: 2.5rem;">
                        <div
                            style="display:inline-flex; align-items:center; justify-content:center; width:64px; height:64px; background:var(--green-50); color:var(--green-600); border-radius:50%; margin-bottom:1rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                style="width:32px; height:32px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h2
                            style="font-family: var(--font-heading); color: var(--green-800); margin-bottom: 0.5rem; font-size: 2.2rem;">
                            Land Record Search</h2>
                        <p style="color: var(--gray-600); font-size: 1.05rem;">Enter the cadastral details below to find the
                            current settlement stage</p>
                    </div>

                    <form method="POST" action="{{ route('find') }}">
                        @csrf
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">

                            <div>
                                <label for="map_no"
                                    style="display:block; font-family:var(--font-accent); font-weight:600; font-size:0.85rem; color:var(--gray-700); margin-bottom:0.5rem; text-transform:uppercase; letter-spacing:0.05em;">Map
                                    Number</label>
                                <input type="text" id="map_no" name="map_no" class="form-control" placeholder="e.g. 52"
                                    style="width:100%; padding:0.85rem 1rem; border:1px solid var(--gray-200); border-radius:var(--radius-md); font-family:var(--font-body); outline:none; transition:var(--transition-fast);">
                            </div>

                            <div>
                                <label for="block_no"
                                    style="display:block; font-family:var(--font-accent); font-weight:600; font-size:0.85rem; color:var(--gray-700); margin-bottom:0.5rem; text-transform:uppercase; letter-spacing:0.05em;">Block
                                    Number</label>
                                <input type="text" id="block_no" name="block_no" class="form-control" placeholder="e.g. 04"
                                    style="width:100%; padding:0.85rem 1rem; border:1px solid var(--gray-200); border-radius:var(--radius-md); font-family:var(--font-body); outline:none; transition:var(--transition-fast);">
                            </div>

                            <div>
                                <label for="sheet_no"
                                    style="display:block; font-family:var(--font-accent); font-weight:600; font-size:0.85rem; color:var(--gray-700); margin-bottom:0.5rem; text-transform:uppercase; letter-spacing:0.05em;">Sheet
                                    Number</label>
                                <input type="text" id="sheet_no" name="sheet_no" class="form-control" placeholder="e.g. 12"
                                    style="width:100%; padding:0.85rem 1rem; border:1px solid var(--gray-200); border-radius:var(--radius-md); font-family:var(--font-body); outline:none; transition:var(--transition-fast);">
                            </div>

                            <div>
                                <label for="lot_no"
                                    style="display:block; font-family:var(--font-accent); font-weight:600; font-size:0.85rem; color:var(--gray-700); margin-bottom:0.5rem; text-transform:uppercase; letter-spacing:0.05em;">Lot
                                    No.</label>
                                <input type="text" id="lot_no" name="lot_no" class="form-control" placeholder="e.g. 1045"
                                    style="width:100%; padding:0.85rem 1rem; border:1px solid var(--gray-200); border-radius:var(--radius-md); font-family:var(--font-body); outline:none; transition:var(--transition-fast);">
                            </div>

                        </div>

                        <div style="text-align: center;">
                            <button type="submit" class="btn btn-primary"
                                style="padding: 1rem 3rem; font-size: 1.1rem; width: 100%; justify-content: center;">
                                Search Records
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" style="width:20px; height:20px; margin-left:0.5rem;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </form>

                </div>

                {{-- Results Section --}}
                @if($searched)
                    <div id="results" class="reveal visible" style="animation: fadeInUp 0.5s ease both;">
                        @if($result)
                            <div
                                style="background:var(--white); border-radius:var(--radius-xl); box-shadow:var(--shadow-md); padding:3rem; border: 1px solid var(--green-100);">
                                <div
                                    style="display:flex; align-items:center; gap:1rem; margin-bottom: 2rem; border-bottom: 1px solid var(--gray-100); padding-bottom: 1.5rem;">
                                    <div
                                        style="width:52px; height:52px; background:var(--green-50); border-radius:var(--radius-md); display:flex; align-items:center; justify-content:center; color:var(--green-600);">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" style="width:28px;height:28px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3
                                            style="font-family:var(--font-heading); color:var(--green-900); margin:0; font-size:1.6rem;">
                                            Record Found</h3>
                                        <p style="color:var(--gray-500); margin:0; font-size:0.9rem;">Details matching your criteria
                                        </p>
                                    </div>
                                </div>

                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                                    {{-- Data Fields --}}
                                    <div>
                                        <span
                                            style="display:block; font-family:var(--font-accent); font-size:0.75rem; color:var(--gray-500); text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.25rem;">Owner
                                            / Claimant Name</span>
                                        <strong style="color:var(--gray-800); font-size:1.1rem;">{{ $result['name'] }}</strong>
                                    </div>
                                    <div>
                                        <span
                                            style="display:block; font-family:var(--font-accent); font-size:0.75rem; color:var(--gray-500); text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.25rem;">Land
                                            Size</span>
                                        <strong style="color:var(--gray-800); font-size:1.1rem;">{{ $result['size'] }}</strong>
                                    </div>
                                    <div>
                                        <span
                                            style="display:block; font-family:var(--font-accent); font-size:0.75rem; color:var(--gray-500); text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.25rem;">Current
                                            Stage</span>
                                        <span
                                            style="display:inline-block; padding:0.35rem 0.8rem; background:#dbeafe; color:#1e40af; border-radius:999px; font-weight:600; font-size:0.85rem;">{{ $result['current_stage'] }}</span>
                                    </div>
                                    <div>
                                        <span
                                            style="display:block; font-family:var(--font-accent); font-size:0.75rem; color:var(--gray-500); text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.25rem;">File
                                            Number</span>
                                        <strong
                                            style="color:var(--gray-800); font-size:1.1rem;">{{ $result['file_number'] }}</strong>
                                    </div>
                                    <div>
                                        <span
                                            style="display:block; font-family:var(--font-accent); font-size:0.75rem; color:var(--gray-500); text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.25rem;">Gazette
                                            Number</span>
                                        <strong
                                            style="color:var(--gray-800); font-size:1.1rem;">{{ $result['gazette_number'] }}</strong>
                                    </div>
                                    <div>
                                        <span
                                            style="display:block; font-family:var(--font-accent); font-size:0.75rem; color:var(--gray-500); text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.25rem;">Gazetted
                                            Date</span>
                                        <strong
                                            style="color:var(--gray-800); font-size:1.1rem;">{{ date('F j, Y', strtotime($result['gazetted_date'])) }}</strong>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div
                                style="background:var(--white); border-radius:var(--radius-xl); box-shadow:var(--shadow-md); padding:3rem; text-align:center; border: 1px solid #fee2e2;">
                                <div
                                    style="display:inline-flex; align-items:center; justify-content:center; width:64px; height:64px; background:#fef2f2; color:#dc2626; border-radius:50%; margin-bottom:1.5rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        style="width:32px; height:32px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3
                                    style="font-family:var(--font-heading); color:var(--gray-900); font-size:1.5rem; margin-bottom:0.5rem;">
                                    No Records Found</h3>
                                <p style="color:var(--gray-600); margin:0;">We couldn't find any settlement records matching those
                                    details. Please check your inputs and try again.</p>
                            </div>
                        @endif
                    </div>
                @endif

            </div>
        </div>
    </div>

    <style>
        .form-control:focus {
            border-color: var(--green-500) !important;
            box-shadow: 0 0 0 4px rgba(58, 148, 102, 0.15) !important;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

@endsection