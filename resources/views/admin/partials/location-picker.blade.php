{{--
    Map location picker for an office. Submits "latitude" and "longitude".
    @include('admin.partials.location-picker', ['lat' => ..., 'lng' => ..., 'addressField' => 'address'])
    addressField = id of the English address input; "Find address" searches for what is typed there.
--}}
@php
    $lat = old('latitude', $lat ?? null);
    $lng = old('longitude', $lng ?? null);
@endphp

@include('partials.leaflet', ['admin' => true])

<fieldset class="form-group loc-picker" data-location-picker
    data-center="{{ json_encode(\App\Support\OfficeLocations::CENTER) }}" data-zoom="{{ \App\Support\OfficeLocations::ZOOM }}"
    data-address-field="{{ $addressField ?? '' }}">
    <legend class="form-legend">Location on the map <span class="hint">(shown on the website's office maps – click the
        office's position on the map, drag the red pin to adjust, or search for the address)</span></legend>

    <div class="loc-search">
        <input type="search" class="form-input" data-loc-query placeholder="Search a place or address in Sri Lanka, e.g. Battaramulla"
            aria-label="Search a place or address">
        <button type="button" class="btn btn-light" data-loc-search>Search</button>
        @if(!empty($addressField))
            <button type="button" class="btn btn-light" data-loc-from-address>Use the address above</button>
        @endif
    </div>
    <ul class="loc-results" data-loc-results hidden></ul>
    <small class="form-error" data-loc-message hidden></small>

    <div class="loc-map" data-loc-map></div>

    <div class="loc-coords">
        <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="text" inputmode="decimal" id="latitude" name="latitude" value="{{ $lat }}"
                placeholder="e.g. 6.9061" class="form-input @error('latitude') is-invalid @enderror">
        </div>
        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="text" inputmode="decimal" id="longitude" name="longitude" value="{{ $lng }}"
                placeholder="e.g. 79.9230" class="form-input @error('longitude') is-invalid @enderror">
        </div>
        <button type="button" class="btn btn-light" data-loc-clear>Clear location</button>
    </div>
    @error('latitude') <small class="form-error">{{ $message }}</small> @enderror
    @if(!$errors->has('latitude'))
        @error('longitude') <small class="form-error">{{ $message }}</small> @enderror
    @endif
    <small class="hint" data-loc-status></small>
</fieldset>

@push('scripts')
    <script>
        (() => {
            const root = document.querySelector('[data-location-picker]');
            if (!root || typeof L === 'undefined') return;

            const latInput = root.querySelector('#latitude');
            const lngInput = root.querySelector('#longitude');
            const status = root.querySelector('[data-loc-status]');
            const message = root.querySelector('[data-loc-message]');
            const results = root.querySelector('[data-loc-results]');
            const query = root.querySelector('[data-loc-query]');
            const BOUNDS = L.latLngBounds([{{ \App\Support\OfficeLocations::BOUNDS['lat_min'] }}, {{ \App\Support\OfficeLocations::BOUNDS['lng_min'] }}],
                                          [{{ \App\Support\OfficeLocations::BOUNDS['lat_max'] }}, {{ \App\Support\OfficeLocations::BOUNDS['lng_max'] }}]);

            const map = L.map(root.querySelector('[data-loc-map]'), { scrollWheelZoom: true })
                .setView(JSON.parse(root.dataset.center), Number(root.dataset.zoom));
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a>',
            }).addTo(map);

            // Red pin (no image files needed)
            const pinIcon = L.divIcon({ className: 'loc-pin', html: '<span></span>', iconSize: [26, 26], iconAnchor: [13, 26] });
            let pin = null;

            const showMessage = (text) => { message.textContent = text || ''; message.hidden = !text; };

            function setPoint(latlng, { pan = true, zoom = null } = {}) {
                if (!BOUNDS.contains(latlng)) {
                    showMessage('That place is outside Sri Lanka. Please choose the office location in Sri Lanka.');
                    return;
                }
                showMessage('');
                const lat = Number(latlng.lat.toFixed(7));
                const lng = Number(latlng.lng.toFixed(7));
                latInput.value = lat;
                lngInput.value = lng;
                if (!pin) {
                    pin = L.marker([lat, lng], { icon: pinIcon, draggable: true }).addTo(map);
                    pin.on('dragend', () => setPoint(pin.getLatLng(), { pan: false }));
                } else {
                    pin.setLatLng([lat, lng]);
                }
                if (zoom) map.setView([lat, lng], zoom);
                else if (pan) map.panTo([lat, lng]);
                status.textContent = 'Location set. Save the form to keep it.';
            }

            function clearPoint() {
                if (pin) { map.removeLayer(pin); pin = null; }
                latInput.value = '';
                lngInput.value = '';
                status.textContent = 'No location – this office will not appear on the maps.';
            }

            map.on('click', (e) => setPoint(e.latlng, { pan: false }));
            root.querySelector('[data-loc-clear]').addEventListener('click', clearPoint);

            // Typing coordinates moves the pin
            [latInput, lngInput].forEach((input) => input.addEventListener('change', () => {
                const lat = parseFloat(latInput.value);
                const lng = parseFloat(lngInput.value);
                if (Number.isFinite(lat) && Number.isFinite(lng)) setPoint(L.latLng(lat, lng), { zoom: Math.max(map.getZoom(), 14) });
                else if (!latInput.value && !lngInput.value) clearPoint();
            }));

            // Address search (OpenStreetMap Nominatim, Sri Lanka only)
            async function search(text) {
                text = (text || '').trim();
                results.hidden = true;
                results.innerHTML = '';
                if (text.length < 3) { showMessage('Type at least 3 letters to search.'); return; }
                showMessage('');
                status.textContent = 'Searching…';
                try {
                    const url = 'https://nominatim.openstreetmap.org/search?format=json&limit=6&countrycodes=lk&q=' + encodeURIComponent(text);
                    const response = await fetch(url, { headers: { 'Accept-Language': 'en' } });
                    const places = await response.json();
                    status.textContent = '';
                    if (!places.length) { showMessage('No place found. Try a shorter search (e.g. the town name), or click the map.'); return; }
                    places.forEach((place) => {
                        const li = document.createElement('li');
                        const button = document.createElement('button');
                        button.type = 'button';
                        button.textContent = place.display_name;
                        button.addEventListener('click', () => {
                            setPoint(L.latLng(Number(place.lat), Number(place.lon)), { zoom: 16 });
                            results.hidden = true;
                            status.textContent = 'Check the pin and drag it onto the office building if needed, then save.';
                        });
                        li.appendChild(button);
                        results.appendChild(li);
                    });
                    results.hidden = false;
                } catch {
                    status.textContent = '';
                    showMessage('Search is not available right now. Click the office position on the map instead.');
                }
            }

            root.querySelector('[data-loc-search]').addEventListener('click', () => search(query.value));
            query.addEventListener('keydown', (e) => { if (e.key === 'Enter') { e.preventDefault(); search(query.value); } });
            root.querySelector('[data-loc-from-address]')?.addEventListener('click', () => {
                const field = document.getElementById(root.dataset.addressField);
                const text = (field?.value || '').replace(/\s*\n\s*/g, ', ');
                query.value = text;
                search(text);
            });

            // Existing location
            const lat = parseFloat(latInput.value);
            const lng = parseFloat(lngInput.value);
            if (Number.isFinite(lat) && Number.isFinite(lng)) setPoint(L.latLng(lat, lng), { zoom: 16 });
            status.textContent = pin ? 'Drag the pin or click the map to change the location.' : 'No location yet – click the office position on the map.';
        })();
    </script>
@endpush
