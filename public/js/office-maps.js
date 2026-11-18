/* ============================================================
   Office maps (Leaflet + OpenStreetMap)
   - [data-office-map]    homepage: every office as a red dot; clicking a dot opens its contact details
   - [data-location-map]  Contact Us pages: one office (created when scrolled into view)
   ============================================================ */

(() => {
    if (typeof L === 'undefined') return;

    const SRI_LANKA = [[5.85, 79.5], [9.9, 81.95]];
    const TILES = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    const ATTRIBUTION = '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">OpenStreetMap</a>';

    const RED = '#d62828';
    const DOT = { radius: 7, color: '#ffffff', weight: 2, fillColor: RED, fillOpacity: 1 };
    const HEAD_DOT = { radius: 10, color: '#ffffff', weight: 3, fillColor: '#9b1c1c', fillOpacity: 1 };

    const escapeHtml = (text) => String(text ?? '').replace(/[&<>"']/g, (c) => (
        { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]
    ));

    function baseMap(el, options = {}) {
        const map = L.map(el, { scrollWheelZoom: false, ...options });
        L.tileLayer(TILES, { maxZoom: 18, attribution: ATTRIBUTION }).addTo(map);
        // Zoom with the wheel only after the visitor clicks the map (page scrolling is not hijacked)
        map.on('click focus', () => map.scrollWheelZoom.enable());
        map.on('mouseout blur', () => map.scrollWheelZoom.disable());
        return map;
    }

    /* ── Homepage: all offices ─────────────────────────────── */
    document.querySelectorAll('[data-office-map]').forEach((el) => {
        let offices = [];
        try { offices = JSON.parse(el.querySelector('script[type="application/json"]')?.textContent || '[]'); } catch { /* none */ }

        const canvas = el.querySelector('.office-map-canvas');
        const map = baseMap(canvas, { minZoom: 6, maxBounds: [[4.5, 78], [11, 83.5]] });
        map.fitBounds(SRI_LANKA);

        const goLabel = el.dataset.goLabel || '';

        // Head Office drawn last so it sits on top
        const sorted = [...offices].sort((a, b) => (a.type === 'head') - (b.type === 'head'));
        sorted.forEach((office) => {
            const pulse = L.circleMarker([office.lat, office.lng], {
                radius: office.type === 'head' ? 18 : 13, stroke: false, fillColor: RED, fillOpacity: .18,
                interactive: false, className: 'office-dot-halo',
            }).addTo(map);

            const dot = L.circleMarker([office.lat, office.lng], {
                ...(office.type === 'head' ? HEAD_DOT : DOT),
                className: 'office-dot',
                bubblingMouseEvents: false,
            }).addTo(map);

            dot.bindTooltip(
                `<strong>${escapeHtml(office.name)}</strong>`
                + (office.address ? `<br><span>${escapeHtml(office.address)}</span>` : '')
                + `<br><em>${escapeHtml(goLabel)} →</em>`,
                { direction: 'top', offset: [0, -8], className: 'office-tooltip' }
            );
            dot.on('click', () => { window.location.href = office.url; });
            dot.on('mouseover', () => pulse.setStyle({ fillOpacity: .32 }));
            dot.on('mouseout', () => pulse.setStyle({ fillOpacity: .18 }));

            // Keyboard: the dot's SVG path can be focused and opened with Enter
            const path = dot.getElement();
            if (path) {
                path.setAttribute('tabindex', '0');
                path.setAttribute('role', 'link');
                path.setAttribute('aria-label', office.name);
                path.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); window.location.href = office.url; }
                });
                path.addEventListener('focus', () => dot.openTooltip());
                path.addEventListener('blur', () => dot.closeTooltip());
            }
        });

        // Office list next to the map: hovering a name highlights its dot
        el.querySelectorAll('[data-office-index]').forEach((link) => {
            const office = offices[Number(link.dataset.officeIndex)];
            if (!office) return;
            link.addEventListener('mouseenter', () => map.flyTo([office.lat, office.lng], Math.max(map.getZoom(), 8), { duration: .6 }));
        });
    });

    /* ── Contact pages: one office per map ─────────────────── */
    function createSingle(el) {
        if (el.dataset.ready) return;
        el.dataset.ready = '1';
        const lat = Number(el.dataset.lat);
        const lng = Number(el.dataset.lng);
        const map = baseMap(el, { zoomControl: true });
        map.setView([lat, lng], Number(el.dataset.zoom || 15));
        L.circleMarker([lat, lng], { ...HEAD_DOT, radius: 9 }).addTo(map)
            .bindTooltip(escapeHtml(el.dataset.name || ''), { direction: 'top', offset: [0, -8], className: 'office-tooltip' });
    }

    const singles = document.querySelectorAll('[data-location-map]');
    if ('IntersectionObserver' in window) {
        const io = new IntersectionObserver((entries) => entries.forEach((entry) => {
            if (entry.isIntersecting) { createSingle(entry.target); io.unobserve(entry.target); }
        }), { rootMargin: '200px' });
        singles.forEach((el) => io.observe(el));
    } else {
        singles.forEach(createSingle);
    }

    // Arriving from the homepage map (…#office-12): make sure that card's map is drawn
    const target = location.hash.length > 1 ? document.getElementById(decodeURIComponent(location.hash.slice(1))) : null;
    target?.querySelectorAll('[data-location-map]').forEach(createSingle);
})();
