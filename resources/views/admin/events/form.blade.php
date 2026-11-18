@extends('layouts.admin')

@section('title', $item->exists ? 'Edit Event' : 'Add Event')

@section('content')

    <a href="{{ route('admin.events.index') }}" class="back-link">&larr; Back to Events</a>

    @if(request()->boolean('upload_too_large'))
        <div class="alert alert-error" role="alert">
            The photos were too large to upload in one save (the server accepts up to
            {{ number_format(\App\Models\Event::serverUploadLimit() / 1024 / 1024) }} MB at a time), so nothing was saved.
            Please save with fewer photos, then edit the event to add the rest.
        </div>
    @endif

    <form method="POST" action="{{ $item->exists ? route('admin.events.update', $item) : route('admin.events.store') }}"
        enctype="multipart/form-data" class="panel form-panel" id="event-form" novalidate>
        @csrf
        @if($item->exists)
            @method('PUT')
        @endif

        <div class="form-group form-narrow">
            <label for="event_date">Date</label>
            <input type="date" id="event_date" name="event_date"
                value="{{ old('event_date', $item->event_date?->format('Y-m-d')) }}"
                class="form-input @error('event_date') is-invalid @enderror">
            @error('event_date') <small class="form-error">{{ $message }}</small> @enderror
        </div>

        {{-- English / Sinhala / Tamil tabs – each with its own title, description, story and photos --}}
        @include('admin.partials.translation-tabs', ['item' => $item, 'panelExtra' => 'admin.events.partials.photos'])

        <small class="form-error" id="upload-total-error" hidden></small>

        @include('admin.partials.publish-options', ['item' => $item])

        <div class="form-actions">
            <button type="submit" class="btn btn-primary" id="event-submit">{{ $item->exists ? 'Save Changes' : 'Create Event' }}</button>
            <a href="{{ $item->exists ? route('admin.events.show', $item) : route('admin.events.index') }}" class="btn btn-light">Cancel</a>        </div>
    </form>

@endsection

@push('scripts')
    <script>
        (function () {
            const MAX_IMAGES = {{ \App\Models\Event::MAX_IMAGES }};
            const MAX_BYTES = {{ \App\Models\Event::MAX_IMAGE_KB }} * 1024;
            const SERVER_LIMIT = {{ \App\Models\Event::serverUploadLimit() }}; // whole form, bytes (0 = no limit)
            const TYPES = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            const mb = bytes => (bytes / 1024 / 1024).toFixed(1) + ' MB';

            const form = document.getElementById('event-form');
            const uploaders = [];

            // One uploader per language tab. Each keeps its own list of chosen files.
            document.querySelectorAll('[data-photo-uploader]').forEach(function (root) {
                const label = root.dataset.label;
                const input = root.querySelector('input[type=file]');
                const box = root.querySelector('[data-box]');
                const grid = root.querySelector('[data-new]');
                const errorEl = root.querySelector('[data-error]');
                const remainingEl = root.querySelector('[data-remaining]');
                const existing = root.querySelectorAll('[data-existing] input[type=checkbox]');
                const state = { files: [] };
                uploaders.push(state);

                const keptExisting = () => [...existing].filter(c => !c.checked).length;
                const remaining = () => MAX_IMAGES - keptExisting() - state.files.length;

                function showError(msg) {
                    errorEl.textContent = msg || '';
                    errorEl.hidden = !msg;
                }

                function sync() {
                    // Put the chosen files back into this tab's <input> so they are submitted
                    const dt = new DataTransfer();
                    state.files.forEach(f => dt.items.add(f));
                    input.files = dt.files;

                    grid.innerHTML = '';
                    state.files.forEach((file, i) => {
                        const tile = document.createElement('div');
                        tile.className = 'image-tile new';
                        const img = document.createElement('img');
                        img.src = URL.createObjectURL(file);
                        img.alt = file.name;
                        img.onload = () => URL.revokeObjectURL(img.src);
                        const info = document.createElement('span');
                        info.className = 'image-info';
                        info.textContent = mb(file.size);
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'image-remove-btn';
                        btn.setAttribute('aria-label', 'Remove ' + file.name);
                        btn.textContent = '×';
                        btn.onclick = () => { state.files.splice(i, 1); showError(''); sync(); };
                        tile.append(img, info, btn);
                        grid.appendChild(tile);
                    });

                    const left = remaining();
                    remainingEl.textContent = left > 0 ? `– you can add ${left} more` : '– photo limit reached';
                    box.classList.toggle('disabled', left <= 0);
                }

                function addFiles(list) {
                    const problems = [];
                    for (const file of list) {
                        if (!TYPES.includes(file.type)) { problems.push(`${file.name} is not a JPG, PNG, WEBP or GIF image.`); continue; }
                        if (file.size > MAX_BYTES) { problems.push(`${file.name} is ${mb(file.size)} – the maximum is 10 MB.`); continue; }
                        if (remaining() <= 0) { problems.push(`Only ${MAX_IMAGES} ${label} photos are allowed, so some photos were not added.`); break; }
                        state.files.push(file);
                    }
                    showError(problems.join(' '));
                    sync();
                }

                // input.files now only holds the new selection; addFiles() puts back all chosen files
                input.addEventListener('change', () => addFiles([...input.files]));
                box.addEventListener('click', e => {
                    if (remaining() <= 0) { e.preventDefault(); showError(`This tab already has ${MAX_IMAGES} ${label} photos. Remove one to add another.`); }
                });
                ['dragenter', 'dragover'].forEach(ev => box.addEventListener(ev, e => { e.preventDefault(); box.classList.add('dragging'); }));
                ['dragleave', 'drop'].forEach(ev => box.addEventListener(ev, e => { e.preventDefault(); box.classList.remove('dragging'); }));
                box.addEventListener('drop', e => addFiles([...e.dataTransfer.files]));

                existing.forEach(c => c.addEventListener('change', () => {
                    // Keeping this photo again would go over the limit → undo
                    if (!c.checked && remaining() < 0) {
                        c.checked = true;
                        showError(`The ${label} tab can have at most ${MAX_IMAGES} photos. Remove a new photo first.`);
                    }
                    c.closest('.image-tile').classList.toggle('removing', c.checked);
                    sync();
                }));

                sync();
            });

            form.addEventListener('submit', e => {
                const all = uploaders.flatMap(u => u.files);
                const total = all.reduce((sum, f) => sum + f.size, 0);
                const totalError = document.getElementById('upload-total-error');
                if (SERVER_LIMIT && total > SERVER_LIMIT - 1024 * 1024) {
                    e.preventDefault();
                    totalError.textContent = `The new photos in all languages add up to ${mb(total)}, but the server accepts at most `
                        + `${mb(SERVER_LIMIT)} per save. Save with fewer photos, then add the rest by editing the event.`;
                    totalError.hidden = false;
                    totalError.scrollIntoView({ block: 'center' });
                    return;
                }
                totalError.hidden = true;
                const submit = document.getElementById('event-submit');
                submit.disabled = true;
                submit.textContent = all.length ? 'Uploading…' : 'Saving…';
            });
        })();
    </script>
@endpush
