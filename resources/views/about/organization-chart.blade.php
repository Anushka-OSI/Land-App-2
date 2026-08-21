@extends('layouts.app')

@section('title', 'Organization Chart | About Us | Department of Land Title Settlement')

@section('content')

    {{-- Banner --}}
    @include('partials.page-banner', [
        'title' => 'Organization Chart',
        'subtitle' => 'Departmental Hierarchy, Executive Leadership, and Operational Divisions',
        'parent' => 'About Us',
        'parentUrl' => route('about'),
        'showSubnav' => true
    ])

    <div class="about-page-content">
        <div class="container">

            {{-- Organization Structure Intro --}}
            <div class="section-intro-text text-center reveal">
                <span class="section-label">Institutional Structure</span>
                <h2 class="section-title">Department Organization Chart</h2>
                <p class="section-subtitle">Official administrative hierarchy of the Department of Land Title Settlement</p>
            </div>

            {{-- Interactive Image Chart Viewer --}}
            <section class="org-chart-viewer-wrap reveal">
                <div class="viewer-toolbar">
                    <div class="toolbar-info">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Official Organization Structure</span>
                    </div>
                    <div class="toolbar-actions">
                        <button class="toolbar-btn" id="btn-zoom-in" title="Zoom In" aria-label="Zoom in">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
                            Zoom In
                        </button>
                        <button class="toolbar-btn" id="btn-zoom-out" title="Zoom Out" aria-label="Zoom out">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"/></svg>
                            Zoom Out
                        </button>
                        <button class="toolbar-btn" id="btn-zoom-reset" title="Reset Zoom" aria-label="Reset zoom">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Reset
                        </button>
                        <a href="{{ asset('images/organization_structure.jpg') }}" download="Organization_Structure_Land_Settlement.jpg" class="toolbar-btn btn-download" title="Download Image">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Download
                        </a>
                        <button class="toolbar-btn" id="btn-fullscreen" title="Full Screen View" aria-label="Full screen">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                            Full View
                        </button>
                    </div>
                </div>

                <div class="org-image-stage" id="image-stage">
                    <img
                        src="{{ asset('images/organization_structure.jpg') }}"
                        alt="Department of Land Title Settlement - Organization Structure Chart"
                        class="org-structure-img"
                        id="org-chart-img"
                    >
                </div>
                <div class="viewer-hint">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Tip: Use zoom controls above or click on the image to view in high resolution.
                </div>
            </section>

            {{-- Department Divisions Breakdown --}}
            <section class="org-divisions-section reveal">
                <div class="section-header text-center">
                    <span class="section-label">Hierarchy Breakdown</span>
                    <h2 class="section-title">Key Institutional Divisions</h2>
                    <p class="section-subtitle">Functional structure as represented in the organization chart</p>
                </div>

                <div class="divisions-grid">
                    @foreach($departments as $dept)
                        <div class="division-card">
                            <div class="division-card-top"></div>
                            <div class="division-card-body">
                                <div class="division-badge">{{ $dept['title'] }}</div>
                                <h3 class="division-role">{{ $dept['role'] }}</h3>
                                <p class="division-desc">{{ $dept['description'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

        </div>
    </div>

    {{-- Modal Lightbox for Full View --}}
    <div class="lightbox-modal" id="chart-modal" aria-hidden="true" role="dialog">
        <div class="lightbox-overlay" id="lightbox-close-overlay"></div>
        <div class="lightbox-container">
            <button class="lightbox-close" id="lightbox-close-btn" aria-label="Close lightbox">&times;</button>
            <div class="lightbox-body">
                <img src="{{ asset('images/organization_structure.jpg') }}" alt="Full Organization Structure Chart" class="lightbox-img">
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const img = document.getElementById('org-chart-img');
    const stage = document.getElementById('image-stage');
    let scale = 1;

    document.getElementById('btn-zoom-in')?.addEventListener('click', () => {
        scale = Math.min(scale + 0.25, 2.5);
        updateTransform();
    });

    document.getElementById('btn-zoom-out')?.addEventListener('click', () => {
        scale = Math.max(scale - 0.25, 0.75);
        updateTransform();
    });

    document.getElementById('btn-zoom-reset')?.addEventListener('click', () => {
        scale = 1;
        updateTransform();
    });

    function updateTransform() {
        if (img) {
            img.style.transform = `scale(${scale})`;
            img.style.transformOrigin = 'center center';
            img.style.transition = 'transform 0.25s ease';
        }
    }

    // Modal Fullscreen
    const modal = document.getElementById('chart-modal');
    const openBtn = document.getElementById('btn-fullscreen');
    const closeBtn = document.getElementById('lightbox-close-btn');
    const closeOverlay = document.getElementById('lightbox-close-overlay');

    function openModal() {
        if (modal) {
            modal.classList.add('open');
            document.body.style.overflow = 'hidden';
        }
    }
    function closeModal() {
        if (modal) {
            modal.classList.remove('open');
            document.body.style.overflow = '';
        }
    }

    openBtn?.addEventListener('click', openModal);
    img?.addEventListener('click', openModal);
    closeBtn?.addEventListener('click', closeModal);
    closeOverlay?.addEventListener('click', closeModal);
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal?.classList.contains('open')) {
            closeModal();
        }
    });
});
</script>
@endpush
