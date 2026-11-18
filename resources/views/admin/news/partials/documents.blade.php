{{--
    Documents attached to a News item / Notice. Needs $item.
    New files: documents[] + new_document_names[] + new_document_languages[] (same order, filled in by the script below).
    Existing:  document_names[id], document_languages[id], remove_documents[].
--}}
@php
    $documents = $item->exists ? $item->documents : collect();
    $removing = array_map('intval', (array) old('remove_documents', []));
    $languageOptions = ['' => 'All languages'] + collect(\App\Support\Languages::ALL)->map(fn ($l) => $l['label'])->all();
    $hasErrors = $errors->has('documents') || $errors->has('documents.*');
@endphp

<fieldset class="form-group doc-uploader" data-doc-uploader
    data-max="{{ \App\Models\NewsDocument::MAX_DOCUMENTS }}" data-max-bytes="{{ \App\Models\NewsDocument::MAX_KB * 1024 }}"
    data-extensions="{{ implode(',', array_keys(\App\Models\NewsDocument::TYPES)) }}">
    <legend class="form-legend">Documents <span class="hint">(optional – up to {{ \App\Models\NewsDocument::MAX_DOCUMENTS }} files,
        PDF, Word, Excel, PowerPoint, OpenDocument, text, JPG or PNG, max 10 MB each. Visitors can view and download them.)</span></legend>

    @if($documents->isNotEmpty())
        <ul class="doc-list" data-existing>
            @foreach($documents as $document)
                @php $isRemoving = in_array($document->id, $removing, true); @endphp
                <li class="doc-row {{ $isRemoving ? 'removing' : '' }}">
                    <span class="doc-ext doc-ext--{{ $document->extension }}" aria-hidden="true">{{ strtoupper($document->extension) }}</span>
                    <div class="doc-fields">
                        <input type="text" name="document_names[{{ $document->id }}]" maxlength="255" class="form-input"
                            value="{{ old("document_names.{$document->id}", $document->name) }}" aria-label="Name shown on the website">
                        <div class="doc-sub">
                            {{ $document->original_name }} · {{ $document->sizeLabel() }} ·
                            <a href="{{ $document->url() }}" target="_blank" rel="noopener">{{ $document->canView() ? 'View' : 'Download' }} ↗</a>
                        </div>
                    </div>
                    <select name="document_languages[{{ $document->id }}]" class="form-input doc-lang" aria-label="Language of this document">
                        @foreach($languageOptions as $code => $label)
                            <option value="{{ $code }}" @selected((string) old("document_languages.{$document->id}", $document->language) === (string) $code)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <label class="doc-remove">
                        <input type="checkbox" name="remove_documents[]" value="{{ $document->id }}" @checked($isRemoving)>
                        Remove
                    </label>
                </li>
            @endforeach
        </ul>
    @endif

    <div class="upload-box {{ $hasErrors ? 'is-invalid' : '' }}" data-box>
        <input type="file" id="documents" name="documents[]" multiple
            accept="{{ collect(array_keys(\App\Models\NewsDocument::TYPES))->map(fn ($e) => '.' . $e)->implode(',') }}">
        <div class="upload-box-text">
            <strong>Click to choose documents</strong> or drag them here
            <span data-remaining></span>
        </div>
    </div>

    {{-- New files: name and language for each (filled in by the script) --}}
    <ul class="doc-list" data-new></ul>

    <small class="form-error" data-error hidden></small>
    @error('documents') <small class="form-error">{{ $message }}</small> @enderror
    @foreach($errors->get('documents.*') as $messages)
        <small class="form-error">{{ $messages[0] }}</small>
        @break
    @endforeach
    @if($hasErrors || $errors->any())
        <small class="hint">If the form showed errors, choose the new documents again – browsers do not keep chosen files.</small>
    @endif
</fieldset>

@push('scripts')
    <script>
        (() => {
            const root = document.querySelector('[data-doc-uploader]');
            if (!root) return;

            const MAX = Number(root.dataset.max);
            const MAX_BYTES = Number(root.dataset.maxBytes);
            const EXTENSIONS = root.dataset.extensions.split(',');
            const LANGUAGES = @json($languageOptions);

            const input = root.querySelector('input[type=file]');
            const box = root.querySelector('[data-box]');
            const list = root.querySelector('[data-new]');
            const errorEl = root.querySelector('[data-error]');
            const remainingEl = root.querySelector('[data-remaining]');
            const existing = root.querySelectorAll('[data-existing] input[type=checkbox]');

            // { file, name, language }
            let items = [];

            const mb = (bytes) => bytes >= 1048576 ? (bytes / 1048576).toFixed(1) + ' MB' : Math.max(1, Math.round(bytes / 1024)) + ' KB';
            const ext = (file) => (file.name.split('.').pop() || '').toLowerCase();
            const baseName = (file) => file.name.replace(/\.[^.]+$/, '');
            const kept = () => [...existing].filter((c) => !c.checked).length;
            const remaining = () => MAX - kept() - items.length;

            function showError(message) {
                errorEl.textContent = message || '';
                errorEl.hidden = !message;
            }

            function render() {
                // Put the chosen files back into the <input> so they are submitted, in the same order as the rows
                const dt = new DataTransfer();
                items.forEach((item) => dt.items.add(item.file));
                input.files = dt.files;

                list.innerHTML = '';
                items.forEach((item, i) => {
                    const row = document.createElement('li');
                    row.className = 'doc-row new';

                    const badge = document.createElement('span');
                    badge.className = `doc-ext doc-ext--${ext(item.file)}`;
                    badge.textContent = ext(item.file).toUpperCase();

                    const fields = document.createElement('div');
                    fields.className = 'doc-fields';
                    const name = document.createElement('input');
                    name.type = 'text';
                    name.name = 'new_document_names[]';
                    name.maxLength = 255;
                    name.className = 'form-input';
                    name.value = item.name;
                    name.setAttribute('aria-label', 'Name shown on the website');
                    name.addEventListener('input', () => { item.name = name.value; });
                    const sub = document.createElement('div');
                    sub.className = 'doc-sub';
                    sub.textContent = `${item.file.name} · ${mb(item.file.size)} · new`;
                    fields.append(name, sub);

                    const lang = document.createElement('select');
                    lang.name = 'new_document_languages[]';
                    lang.className = 'form-input doc-lang';
                    lang.setAttribute('aria-label', 'Language of this document');
                    Object.entries(LANGUAGES).forEach(([code, label]) => {
                        const option = new Option(label, code, false, code === item.language);
                        lang.add(option);
                    });
                    lang.addEventListener('change', () => { item.language = lang.value; });

                    const remove = document.createElement('button');
                    remove.type = 'button';
                    remove.className = 'btn btn-light btn-sm';
                    remove.textContent = 'Remove';
                    remove.addEventListener('click', () => { items.splice(i, 1); showError(''); render(); });

                    row.append(badge, fields, lang, remove);
                    list.appendChild(row);
                });

                const left = remaining();
                remainingEl.textContent = left > 0 ? `– you can add ${left} more` : '– document limit reached';
                box.classList.toggle('disabled', left <= 0);
            }

            function addFiles(files) {
                const problems = [];
                for (const file of files) {
                    if (!EXTENSIONS.includes(ext(file))) { problems.push(`${file.name} is not an allowed document type.`); continue; }
                    if (file.size > MAX_BYTES) { problems.push(`${file.name} is ${mb(file.size)} – the maximum is 10 MB.`); continue; }
                    if (remaining() <= 0) { problems.push(`Only ${MAX} documents are allowed, so some files were not added.`); break; }
                    items.push({ file, name: baseName(file), language: '' });
                }
                showError(problems.join(' '));
                render();
            }

            input.addEventListener('change', () => addFiles([...input.files]));
            box.addEventListener('click', (e) => {
                if (remaining() <= 0) { e.preventDefault(); showError(`This item already has ${MAX} documents. Remove one to add another.`); }
            });
            ['dragenter', 'dragover'].forEach((ev) => box.addEventListener(ev, (e) => { e.preventDefault(); box.classList.add('dragging'); }));
            ['dragleave', 'drop'].forEach((ev) => box.addEventListener(ev, (e) => { e.preventDefault(); box.classList.remove('dragging'); }));
            box.addEventListener('drop', (e) => addFiles([...e.dataTransfer.files]));

            existing.forEach((checkbox) => checkbox.addEventListener('change', () => {
                if (!checkbox.checked && remaining() < 0) {
                    checkbox.checked = true;
                    showError(`A news item can have at most ${MAX} documents. Remove a new document first.`);
                }
                checkbox.closest('.doc-row').classList.toggle('removing', checkbox.checked);
                render();
            }));

            // Show "Uploading…" while the files are sent
            root.closest('form')?.addEventListener('submit', (e) => {
                const total = items.reduce((sum, item) => sum + item.file.size, 0);
                const limit = {{ \App\Models\Event::serverUploadLimit() }};
                if (limit && total > limit - 1048576) {
                    e.preventDefault();
                    showError(`The new documents add up to ${mb(total)}, but the server accepts at most ${mb(limit)} per save. `
                        + 'Save with fewer documents, then edit the item to add the rest.');
                    errorEl.scrollIntoView({ block: 'center' });
                    return;
                }
                const submit = root.closest('form').querySelector('[type=submit]');
                if (submit && items.length) { submit.disabled = true; submit.textContent = 'Uploading…'; }
            });

            render();
        })();
    </script>
@endpush
