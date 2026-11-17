{{--
    Rich-text editor (Quill, served from public/vendor/quill).
    @include('admin.partials.rich-editor', ['name' => 'body_en', 'lang' => 'en', 'value' => ..., 'label' => 'Full story'])
    The HTML is copied into a hidden input on submit and cleaned on the server (App\Support\RichText).
--}}
@php $editorId = 'editor-' . $name; @endphp

<div class="form-group">
    <label for="{{ $editorId }}-area" id="{{ $editorId }}-label">{{ $label ?? 'Full story' }}
        <span class="hint">({{ isset($labelHint) ? $labelHint . ' – ' : '' }}optional)</span></label>
    <div class="rich-editor @error($name) is-invalid @enderror">
        <div id="{{ $editorId }}" class="rich-editor-area"></div>
    </div>
    <input type="hidden" name="{{ $name }}" id="{{ $editorId }}-input" value="{{ $value }}">
    @error($name) <small class="form-error">{{ $message }}</small> @enderror
</div>

@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('vendor/quill/quill.snow.css') }}">
    @endpush
    @push('scripts')
        <script src="{{ asset('vendor/quill/quill.js') }}"></script>
    @endpush
@endonce

@push('scripts')
    <script>
        (function () {
            const input = document.getElementById(@json($editorId . '-input'));
            const quill = new Quill('#' + @json($editorId), {
                theme: 'snow',
                placeholder: 'Write the full story here…',
                modules: {
                    toolbar: [
                        [{ header: [2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        [{ align: [] }],
                        ['blockquote', 'link'],
                        ['clean'],
                    ],
                },
            });

            // Accessible name + language (picks the right Sinhala / Tamil font while typing)
            quill.root.setAttribute('aria-labelledby', @json($editorId . '-label'));
            quill.root.id = @json($editorId . '-area');
            quill.root.setAttribute('lang', @json($lang ?? 'en'));

            if (input.value) {
                quill.setContents(quill.clipboard.convert({ html: input.value }), 'silent');
            }

            input.form.addEventListener('submit', function () {
                input.value = quill.getText().trim() === '' ? '' : quill.getSemanticHTML();
            });
        })();
    </script>
@endpush
