@extends('layouts.admin')

@section('title', $faq->exists ? 'Edit FAQ' : 'Add FAQ')

@section('content')

    <a href="{{ route('admin.faqs.index') }}" class="back-link">&larr; Back to FAQs</a>

    <form method="POST" action="{{ $faq->exists ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}"
        class="panel form-panel" novalidate>
        @csrf
        @if($faq->exists)
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="question">Question <span class="hint">(English)</span></label>
            <input type="text" id="question" name="question" value="{{ old('question', $faq->question) }}"
                maxlength="255" class="form-input @error('question') is-invalid @enderror">
            @error('question') <small class="form-error">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="answer">Answer <span class="hint">(English)</span></label>
            <textarea id="answer" name="answer" rows="6"
                class="form-input @error('answer') is-invalid @enderror">{{ old('answer', $faq->answer) }}</textarea>
            @error('answer') <small class="form-error">{{ $message }}</small> @enderror
        </div>

        {{-- Sinhala and Tamil versions – required, every FAQ is added in all 3 languages --}}
        @foreach(['si' => 'Sinhala (සිංහල)', 'ta' => 'Tamil (தமிழ்)'] as $lang => $languageName)
            <fieldset class="form-group faq-translation">
                <legend>{{ $languageName }} <span class="hint">(required)</span></legend>

                <div class="form-group">
                    <label for="question_{{ $lang }}">Question in {{ $languageName }}</label>
                    <input type="text" id="question_{{ $lang }}" name="question_{{ $lang }}" lang="{{ $lang }}"
                        value="{{ old("question_{$lang}", $faq->{"question_{$lang}"}) }}" maxlength="255"
                        class="form-input @error("question_{$lang}") is-invalid @enderror">
                    @error("question_{$lang}") <small class="form-error">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="answer_{{ $lang }}">Answer in {{ $languageName }}</label>
                    <textarea id="answer_{{ $lang }}" name="answer_{{ $lang }}" rows="5" lang="{{ $lang }}"
                        class="form-input @error("answer_{$lang}") is-invalid @enderror">{{ old("answer_{$lang}", $faq->{"answer_{$lang}"}) }}</textarea>
                    @error("answer_{$lang}") <small class="form-error">{{ $message }}</small> @enderror
                </div>
            </fieldset>
        @endforeach

        <div class="form-row">
            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category" class="form-input @error('category') is-invalid @enderror">
                    @foreach(\App\Models\Faq::CATEGORIES as $key => $label)
                        <option value="{{ $key }}" @selected(old('category', $faq->category) === $key)>{{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('category') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="sort_order">Display order <span class="hint">(lower numbers show first)</span></label>
                <input type="number" id="sort_order" name="sort_order" min="0"
                    value="{{ old('sort_order', $faq->sort_order) }}"
                    class="form-input @error('sort_order') is-invalid @enderror">
                @error('sort_order') <small class="form-error">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="keywords">Keywords <span class="hint">(comma separated – helps suggest this FAQ when visitors
                    type a question)</span></label>
            <input type="text" id="keywords" name="keywords"
                value="{{ old('keywords', implode(', ', $faq->keywords ?? [])) }}"
                placeholder="e.g. certificate, title deed, ownership"
                class="form-input @error('keywords') is-invalid @enderror">
            @error('keywords') <small class="form-error">{{ $message }}</small> @enderror
        </div>

        <div class="form-checks">
            <label class="form-check">
                <input type="checkbox" name="is_published" value="1"
                    {{ old('is_published', $faq->is_published) ? 'checked' : '' }}>
                <span><strong>Published</strong> – visible on the FAQ page</span>
            </label>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">{{ $faq->exists ? 'Save Changes' : 'Create FAQ' }}</button>
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </form>

@endsection
