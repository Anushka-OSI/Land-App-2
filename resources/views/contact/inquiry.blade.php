@extends('layouts.app')

@section('title', 'Contact Us – Inquiry | Department of Land Title Settlement')

@section('content')

    {{-- Banner --}}
    @include('partials.page-banner', [
        'title' => 'Contact Us – Inquiry',
        'subtitle' => 'Get in touch with the Department of Land Title Settlement',
        'parent' => 'Contact Us',
        'parentUrl' => route('contact.inquiry'),
        'showContactnav' => true
    ])

    <div style="background: var(--gray-50); padding: 4rem 0;">
        <div class="container">

            {{-- ─── Quick Contact Strip ─────────────────────────── --}}
            <div
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 3.5rem;">

                {{-- Address --}}
                <div
                    style="background:var(--white); border-radius:var(--radius-lg); padding:2rem; box-shadow:var(--shadow-sm); display:flex; gap:1.25rem; align-items:flex-start; border-left:4px solid var(--green-600);">
                    <div
                        style="width:48px; height:48px; background:var(--green-50); border-radius:var(--radius-md); display:flex; align-items:center; justify-content:center; flex-shrink:0; color:var(--green-600);">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            style="width:24px;height:24px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4
                            style="font-family:var(--font-heading); color:var(--green-800); font-size:1.1rem; margin-bottom:.35rem;">
                            Head Office Address</h4>
                        <p style="color:var(--gray-600); font-size:.92rem; line-height:1.6; margin:0;">
                            Department of Land Title Settlement,<br>
                            1200/7, Rajamalwatta Road,<br>
                            Battaramulla, Sri Lanka.
                        </p>
                    </div>
                </div>

                {{-- Emergency Hotline --}}
                <div
                    style="background:var(--white); border-radius:var(--radius-lg); padding:2rem; box-shadow:var(--shadow-sm); display:flex; gap:1.25rem; align-items:flex-start; border-left:4px solid var(--gold-500);">
                    <div
                        style="width:48px; height:48px; background:var(--gold-100); border-radius:var(--radius-md); display:flex; align-items:center; justify-content:center; flex-shrink:0; color:var(--gold-600);">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            style="width:24px;height:24px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <div>
                        <h4
                            style="font-family:var(--font-heading); color:var(--green-800); font-size:1.1rem; margin-bottom:.35rem;">
                            Contact Numbers</h4>
                        <p style="color:var(--gray-600); font-size:.92rem; line-height:1.8; margin:0;">
                            <strong>General:</strong> +94 11 2888 935<br>
                            <strong>Fax:</strong> +94 11 2888 937
                        </p>
                    </div>
                </div>

                {{-- Email --}}
                <div
                    style="background:var(--white); border-radius:var(--radius-lg); padding:2rem; box-shadow:var(--shadow-sm); display:flex; gap:1.25rem; align-items:flex-start; border-left:4px solid var(--green-800);">
                    <div
                        style="width:48px; height:48px; background:var(--green-50); border-radius:var(--radius-md); display:flex; align-items:center; justify-content:center; flex-shrink:0; color:var(--green-700);">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            style="width:24px;height:24px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h4
                            style="font-family:var(--font-heading); color:var(--green-800); font-size:1.1rem; margin-bottom:.35rem;">
                            Email Address</h4>
                        <p style="color:var(--gray-600); font-size:.92rem; line-height:1.8; margin:0;">
                            <a href="mailto:info@landtitle.gov.lk"
                                style="color:var(--green-600); font-weight:600;">info@landtitle.gov.lk</a>
                        </p>
                    </div>
                </div>

            </div>

            {{-- ─── Inquiry Form ───────────────────────────────── --}}
            <div style="max-width:860px; margin:0 auto;">
                <div
                    style="background:var(--white); border-radius:var(--radius-xl); box-shadow:var(--shadow-lg); overflow:hidden; position:relative;">

                    {{-- Gradient Top Bar --}}
                    <div style="height:6px; background:linear-gradient(90deg, var(--green-600), var(--gold-500));"></div>

                    <div style="padding:3rem;">

                        {{-- Header --}}
                        <div style="text-align:center; margin-bottom:2.5rem;">
                            <div
                                style="display:inline-flex; align-items:center; justify-content:center; width:64px; height:64px; background:var(--green-50); color:var(--green-600); border-radius:50%; margin-bottom:1rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" style="width:32px;height:32px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <h2
                                style="font-family:var(--font-heading); color:var(--green-800); font-size:2rem; margin-bottom:.5rem;">
                                Send Us an Inquiry</h2>
                            <p style="color:var(--gray-500); font-size:1rem;">Fill out the form below and our team will
                                respond within 3–5 working days</p>
                        </div>

                        {{-- Success Flash --}}
                        @if(session('success'))
                            <div
                                style="background:#ecfdf5; border:1px solid #a7f3d0; color:#065f46; border-radius:var(--radius-md); padding:1rem 1.5rem; margin-bottom:2rem; font-weight:500; display:flex; align-items:center; gap:.75rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    style="width:22px;height:22px; flex-shrink:0;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- Validation Errors --}}
                        @if($errors->any())
                            <div
                                style="background:#fef2f2; border:1px solid #fecaca; color:#991b1b; border-radius:var(--radius-md); padding:1rem 1.5rem; margin-bottom:2rem;">
                                <ul style="list-style:disc; padding-left:1.25rem; margin:0;">
                                    @foreach ($errors->all() as $error)
                                        <li style="font-size:.9rem;">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('contact.inquiry.submit') }}">
                            @csrf

                            {{-- Row 1: Name & Email --}}
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; margin-bottom:1.5rem;">
                                <div>
                                    <label for="full_name"
                                        style="display:block; font-family:var(--font-accent); font-weight:600; font-size:.82rem; color:var(--gray-700); margin-bottom:.45rem; text-transform:uppercase; letter-spacing:.05em;">Full
                                        Name <span style="color:#dc2626;">*</span></label>
                                    <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}"
                                        required placeholder="e.g. W. A. Samarathunga"
                                        style="width:100%; padding:.85rem 1rem; border:1px solid var(--gray-200); border-radius:var(--radius-md); font-family:var(--font-body); font-size:.95rem; outline:none; transition:var(--transition-fast); background:var(--gray-50);">
                                </div>
                                <div>
                                    <label for="email"
                                        style="display:block; font-family:var(--font-accent); font-weight:600; font-size:.82rem; color:var(--gray-700); margin-bottom:.45rem; text-transform:uppercase; letter-spacing:.05em;">Email
                                        Address <span style="color:#dc2626;">*</span></label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                        placeholder="e.g. your@email.com"
                                        style="width:100%; padding:.85rem 1rem; border:1px solid var(--gray-200); border-radius:var(--radius-md); font-family:var(--font-body); font-size:.95rem; outline:none; transition:var(--transition-fast); background:var(--gray-50);">
                                </div>
                            </div>

                            {{-- Row 2: Subject & Office --}}
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; margin-bottom:1.5rem;">
                                <div>
                                    <label for="subject"
                                        style="display:block; font-family:var(--font-accent); font-weight:600; font-size:.82rem; color:var(--gray-700); margin-bottom:.45rem; text-transform:uppercase; letter-spacing:.05em;">Subject
                                        <span style="color:#dc2626;">*</span></label>
                                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                                        placeholder="e.g. Title Certificate Inquiry"
                                        style="width:100%; padding:.85rem 1rem; border:1px solid var(--gray-200); border-radius:var(--radius-md); font-family:var(--font-body); font-size:.95rem; outline:none; transition:var(--transition-fast); background:var(--gray-50);">
                                </div>
                                <div>
                                    <label for="office"
                                        style="display:block; font-family:var(--font-accent); font-weight:600; font-size:.82rem; color:var(--gray-700); margin-bottom:.45rem; text-transform:uppercase; letter-spacing:.05em;">Relevant
                                        Office <span style="color:#dc2626;">*</span></label>
                                    <select id="office" name="office" required
                                        style="width:100%; padding:.85rem 1rem; border:1px solid var(--gray-200); border-radius:var(--radius-md); font-family:var(--font-body); font-size:.95rem; outline:none; transition:var(--transition-fast); background:var(--gray-50); cursor:pointer; color:var(--gray-700); appearance:none; background-image:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 20 20%22 fill=%22%236b7280%22><path fill-rule=%22evenodd%22 d=%22M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z%22 clip-rule=%22evenodd%22/></svg>'); background-repeat:no-repeat; background-position:right .8rem center; background-size:16px; padding-right:2.5rem;">
                                        <option value="" disabled {{ old('office') ? '' : 'selected' }}>Select an office…
                                        </option>
                                        @foreach($offices as $office)
                                            <option value="{{ $office }}" {{ old('office') === $office ? 'selected' : '' }}>
                                                {{ $office }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Row 3: Message --}}
                            <div style="margin-bottom:2rem;">
                                <label for="message"
                                    style="display:block; font-family:var(--font-accent); font-weight:600; font-size:.82rem; color:var(--gray-700); margin-bottom:.45rem; text-transform:uppercase; letter-spacing:.05em;">Message
                                    <span style="color:#dc2626;">*</span></label>
                                <textarea id="message" name="message" rows="6" required
                                    placeholder="Describe your inquiry in detail…"
                                    style="width:100%; padding:1rem; border:1px solid var(--gray-200); border-radius:var(--radius-md); font-family:var(--font-body); font-size:.95rem; outline:none; transition:var(--transition-fast); background:var(--gray-50); resize:vertical; min-height:140px;">{{ old('message') }}</textarea>
                            </div>

                            {{-- Submit --}}
                            <div style="text-align:center;">
                                <button type="submit" class="btn btn-primary"
                                    style="padding:1rem 3rem; font-size:1.05rem; width:100%; justify-content:center;">
                                    Submit Inquiry
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" style="width:20px;height:20px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Focus styles --}}
    <style>
        #full_name:focus,
        #email:focus,
        #subject:focus,
        #office:focus,
        #message:focus {
            border-color: var(--green-500) !important;
            box-shadow: 0 0 0 4px rgba(58, 148, 102, 0.15) !important;
            background: var(--white) !important;
        }

        @media (max-width:640px) {
            div[style*="grid-template-columns:1fr 1fr"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>

@endsection