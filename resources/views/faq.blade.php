@extends('layouts.app')

@section('title', __('FAQ | Department of Land Title Settlement'))

@section('content')

    {{-- Banner --}}
    @include('partials.page-banner', [
        'title' => __('Frequently Asked Questions'),
        'subtitle' => __('Answers to common questions about land settlement, title registration and finding your land records'),
    ])

    <div class="faq-page">
        <div class="container">

            {{-- ─── Search + Category Filter ─────────────────────── --}}
            <div class="faq-toolbar">
                <div class="faq-search">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <label for="faq-filter" class="sr-only">{{ __('Search the FAQ') }}</label>
                    <input type="search" id="faq-filter" placeholder="{{ __('Search the FAQ (e.g. certificate, lot number, objection)') }}"
                        autocomplete="off">
                </div>

                <div class="faq-categories" role="tablist" aria-label="{{ __('FAQ categories') }}">
                    <button type="button" class="faq-chip active" data-category="all">{{ __('All') }}</button>
                    @foreach($categories as $key => $label)
                        <button type="button" class="faq-chip" data-category="{{ $key }}">{{ $label }}</button>
                    @endforeach
                </div>
            </div>

            {{-- ─── FAQ List ─────────────────────────────────────── --}}
            <div class="faq-list" id="faq-list">
                @foreach($categories as $key => $label)
                    <section class="faq-group" data-category="{{ $key }}">
                        <h2 class="faq-group-title">{{ $label }}</h2>

                        @foreach(collect($faqs)->where('category', $key) as $faq)
                            <details class="faq-item" id="faq-{{ $faq['id'] }}" data-category="{{ $key }}">
                                <summary>
                                    <span class="faq-q">{{ $faq['question'] }}</span>
                                    <svg class="faq-chevron" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </summary>
                                <div class="faq-a">{{ $faq['answer'] }}</div>
                            </details>
                        @endforeach
                    </section>
                @endforeach

                <div class="faq-empty" id="faq-empty" hidden>
                    {{ __('No questions match your search. Try different words, or ask us your question below.') }}
                </div>
            </div>

            {{-- ─── Ask a Question ───────────────────────────────── --}}
            <section class="faq-ask" id="ask-question" aria-labelledby="ask-title">
                <div class="faq-ask-grid">

                    {{-- Form --}}
                    <div class="faq-ask-form-wrap">
                        <h2 id="ask-title">{{ __('Didn\'t find your answer?') }}</h2>
                        <p class="faq-ask-intro">{{ __('Ask your question below. As you type, we\'ll suggest related questions that may already answer it.') }}</p>

                        @if(session('success'))
                            <div class="faq-alert" role="status">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('faq.ask') }}" class="faq-ask-form" novalidate>
                            @csrf

                            <div class="faq-field">
                                <label for="ask-question-input">{{ __('Your Question') }}</label>
                                <textarea id="ask-question-input" name="question" rows="4" maxlength="2000"
                                    placeholder="{{ __('e.g. How can I get a certificate of title for my land?') }}"
                                    class="@error('question') is-invalid @enderror">{{ old('question') }}</textarea>
                                @error('question')
                                    <small class="field-error">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="faq-field-row">
                                <div class="faq-field">
                                    <label for="ask-name">{{ __('Your Name') }}</label>
                                    <input type="text" id="ask-name" name="name" value="{{ old('name') }}" maxlength="255"
                                        class="@error('name') is-invalid @enderror">
                                    @error('name')
                                        <small class="field-error">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="faq-field">
                                    <label for="ask-email">{{ __('Email Address') }}</label>
                                    <input type="email" id="ask-email" name="email" value="{{ old('email') }}"
                                        maxlength="255" class="@error('email') is-invalid @enderror">
                                    @error('email')
                                        <small class="field-error">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary faq-submit">
                                {{ __('Submit Question') }}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                            </button>
                        </form>
                    </div>

                    {{-- Related FAQ suggestions --}}
                    <aside class="faq-suggest" aria-live="polite">
                        <h3>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            {{ __('Related Questions') }}
                        </h3>
                        <p class="faq-suggest-hint" id="faq-suggest-hint">{{ __('Start typing your question to see related answers.') }}</p>
                        <ul class="faq-suggest-list" id="faq-suggest-list"></ul>
                    </aside>

                </div>
            </section>

        </div>
    </div>

@endsection

@push('styles')
    <style>
        .faq-page {
            background: var(--gray-50);
            padding: 4rem 0 5rem;
        }

        /* Toolbar */
        .faq-toolbar {
            max-width: 900px;
            margin: 0 auto 2.5rem;
        }

        .faq-search {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .faq-search svg {
            position: absolute;
            left: 1.1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: var(--gray-400);
            pointer-events: none;
        }

        .faq-search input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            font-size: 1rem;
            border: 1px solid var(--gray-200);
            border-radius: 999px;
            background: var(--white);
            box-shadow: var(--shadow-sm);
            outline: none;
            transition: var(--transition-fast);
        }

        .faq-search input:focus,
        .faq-field input:focus,
        .faq-field textarea:focus {
            border-color: var(--green-500);
            box-shadow: 0 0 0 4px rgba(58, 148, 102, 0.15);
        }

        .faq-categories {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            justify-content: center;
        }

        .faq-chip {
            border: 1px solid var(--gray-200);
            background: var(--white);
            color: var(--gray-700);
            padding: 0.5rem 1.1rem;
            border-radius: 999px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition-fast);
        }

        .faq-chip:hover {
            border-color: var(--green-500);
            color: var(--green-700);
        }

        .faq-chip.active {
            background: var(--green-600);
            border-color: var(--green-600);
            color: var(--white);
        }

        /* FAQ list */
        .faq-list {
            max-width: 900px;
            margin: 0 auto;
        }

        .faq-group+.faq-group {
            margin-top: 2.5rem;
        }

        .faq-group-title {
            font-family: var(--font-heading);
            font-size: 1.4rem;
            color: var(--green-800);
            margin-bottom: 1rem;
            padding-left: 0.85rem;
            border-left: 4px solid var(--gold-500);
        }

        .faq-item {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-md);
            margin-bottom: 0.75rem;
            transition: var(--transition-fast);
            scroll-margin-top: 120px;
        }

        .faq-item[open] {
            border-color: var(--green-300);
            box-shadow: var(--shadow-md);
        }

        .faq-item.highlight {
            animation: faq-highlight 2s ease;
        }

        @keyframes faq-highlight {

            0%,
            40% {
                box-shadow: 0 0 0 4px rgba(201, 162, 39, 0.45);
            }

            100% {
                box-shadow: var(--shadow-md);
            }
        }

        .faq-item summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.15rem 1.4rem;
            cursor: pointer;
            list-style: none;
        }

        .faq-item summary::-webkit-details-marker {
            display: none;
        }

        .faq-q {
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--gray-800);
        }

        .faq-chevron {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            color: var(--green-600);
            transition: transform 0.2s ease;
        }

        .faq-item[open] .faq-chevron {
            transform: rotate(180deg);
        }

        .faq-a {
            padding: 0 1.4rem 1.3rem;
            color: var(--gray-600);
            line-height: 1.75;
        }

        .faq-empty {
            text-align: center;
            padding: 2rem;
            color: var(--gray-600);
            background: var(--white);
            border-radius: var(--radius-md);
            border: 1px dashed var(--gray-200);
        }

        /* Ask a question */
        .faq-ask {
            max-width: 1100px;
            margin: 4rem auto 0;
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            scroll-margin-top: 100px;
        }

        .faq-ask-grid {
            display: grid;
            grid-template-columns: 3fr 2fr;
        }

        .faq-ask-form-wrap {
            padding: 2.75rem;
        }

        .faq-ask-form-wrap h2 {
            font-family: var(--font-heading);
            font-size: 1.9rem;
            color: var(--green-900);
            margin-bottom: 0.5rem;
        }

        .faq-ask-intro {
            color: var(--gray-600);
            margin-bottom: 1.75rem;
        }

        .faq-alert {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            border-radius: var(--radius-md);
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .faq-alert svg {
            width: 22px;
            height: 22px;
            flex-shrink: 0;
        }

        .faq-field {
            margin-bottom: 1.25rem;
        }

        .faq-field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .faq-field label {
            display: block;
            font-family: var(--font-accent);
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--gray-700);
            margin-bottom: 0.45rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .faq-field input,
        .faq-field textarea {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-md);
            font-size: 1rem;
            outline: none;
            resize: vertical;
            transition: var(--transition-fast);
        }

        .faq-field .is-invalid {
            border-color: #dc2626;
        }

        .faq-field .field-error {
            display: block;
            margin-top: 0.35rem;
            font-size: 0.8rem;
            color: #dc2626;
        }

        .faq-submit svg {
            width: 18px;
            height: 18px;
            margin-left: 0.5rem;
            transform: rotate(90deg);
        }

        .faq-suggest {
            background: var(--green-50);
            border-left: 1px solid var(--green-100);
            padding: 2.75rem 2rem;
        }

        .faq-suggest h3 {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-family: var(--font-heading);
            font-size: 1.25rem;
            color: var(--green-800);
            margin-bottom: 0.75rem;
        }

        .faq-suggest h3 svg {
            width: 22px;
            height: 22px;
            color: var(--gold-500);
        }

        .faq-suggest-hint {
            color: var(--gray-600);
            font-size: 0.92rem;
            margin-bottom: 1rem;
        }

        .faq-suggest-list {
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .faq-suggest-list a {
            display: block;
            background: var(--white);
            border: 1px solid var(--green-100);
            border-radius: var(--radius-md);
            padding: 0.85rem 1rem;
            transition: var(--transition-fast);
        }

        .faq-suggest-list a:hover {
            border-color: var(--green-500);
            box-shadow: var(--shadow-sm);
        }

        .faq-suggest-list strong {
            display: block;
            color: var(--gray-800);
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
        }

        .faq-suggest-list span {
            display: block;
            color: var(--gray-600);
            font-size: 0.85rem;
            line-height: 1.5;
        }

        @media (max-width: 900px) {
            .faq-ask-grid {
                grid-template-columns: 1fr;
            }

            .faq-suggest {
                border-left: none;
                border-top: 1px solid var(--green-100);
            }
        }

        @media (max-width: 640px) {

            .faq-ask-form-wrap,
            .faq-suggest {
                padding: 2rem 1.25rem;
            }

            .faq-field-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        (function () {
            const FAQS = @json($faqs);
            const ASKED = @json(session('asked_question'));

            const STOP_WORDS = new Set(('a an and are as at be can could do does for from get got have how i if in into is it ' +
                'its me my of on or our please should so that the their them there this to was what when where which who ' +
                'why will with would you your yours am been being did had has want need know tell about land lands').split(' '));

            const items = Array.from(document.querySelectorAll('.faq-item'));
            const groups = Array.from(document.querySelectorAll('.faq-group'));
            const chips = Array.from(document.querySelectorAll('.faq-chip'));
            const filterInput = document.getElementById('faq-filter');
            const emptyMsg = document.getElementById('faq-empty');
            const askInput = document.getElementById('ask-question-input');
            const suggestList = document.getElementById('faq-suggest-list');
            const suggestHint = document.getElementById('faq-suggest-hint');

            let activeCategory = 'all';

            function escapeHtml(value) {
                return String(value).replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
            }

            function normalise(text) {
                // keep letters, vowel signs and digits of any script (English, Sinhala, Tamil) and the
                // zero-width joiners used in Sinhala conjuncts such as ශ්‍රී
                return String(text).toLowerCase().replace(/[’']/g, '').replace(/[^\p{L}\p{M}\p{N}‌‍\s]/gu, ' ').replace(/\s+/g, ' ').trim();
            }

            // Crude stemming so "certificates" matches "certificate", "registering" matches "register"
            function stem(word) {
                if (word.length > 4 && word.endsWith('ies')) return word.slice(0, -3) + 'y';   // boundaries -> boundary
                if (word.length > 5 && word.endsWith('ing')) return word.slice(0, -3);         // registering -> register
                if (word.length > 4 && word.endsWith('ed')) return word.slice(0, -2);          // registered -> register
                if (word.length > 3 && word.endsWith('s') && !word.endsWith('ss')) return word.slice(0, -1); // deeds -> deed
                return word;
            }

            function tokens(text) {
                return normalise(text).split(' ').filter(w => w.length > 1 && !STOP_WORDS.has(w)).map(stem);
            }

            // Pre-compute token sets for each FAQ
            const index = FAQS.map(faq => ({
                faq,
                question: new Set(tokens(faq.question)),
                answer: new Set(tokens(faq.answer)),
                keywords: faq.keywords.map(normalise),
                keywordTokens: new Set(faq.keywords.flatMap(tokens)),
            }));

            // Score each FAQ against the user's text and return the best matches
            function related(text, limit = 4) {
                const words = [...new Set(tokens(text))];
                if (words.length === 0) return [];
                const phrase = ' ' + normalise(text) + ' ';

                return index
                    .map(entry => {
                        let score = 0;
                        entry.keywords.forEach(k => { if (k.includes(' ') && phrase.includes(' ' + k + ' ')) score += 4; });
                        words.forEach(w => {
                            if (entry.keywordTokens.has(w)) score += 3;
                            if (entry.question.has(w)) score += 2;
                            if (entry.answer.has(w)) score += 0.5;
                        });
                        return { faq: entry.faq, score };
                    })
                    .filter(r => r.score >= 2)
                    .sort((a, b) => b.score - a.score)
                    .slice(0, limit)
                    .map(r => r.faq);
            }

            // Open an FAQ, scroll to it and briefly highlight it
            function openFaq(id) {
                const item = document.getElementById('faq-' + id);
                if (!item) return;

                // Make sure it is visible (reset filters)
                filterInput.value = '';
                setCategory('all');
                applyFilter();

                item.open = true;
                item.scrollIntoView({ behavior: 'smooth', block: 'center' });
                item.classList.remove('highlight');
                void item.offsetWidth;
                item.classList.add('highlight');
            }

            // ── Suggestions panel ──────────────────────────
            function renderSuggestions(text) {
                const results = related(text);

                if (!text.trim()) {
                    suggestHint.textContent = @json(__('Start typing your question to see related answers.'));
                    suggestList.innerHTML = '';
                    return;
                }

                if (results.length === 0) {
                    suggestHint.textContent = @json(__('No related questions found. Submit your question and our officers will reply.'));
                    suggestList.innerHTML = '';
                    return;
                }

                suggestHint.textContent = @json(__('These questions may already answer yours:'));
                suggestList.innerHTML = results.map(faq => {
                    const preview = faq.answer.length > 120 ? faq.answer.slice(0, 120).trim() + '…' : faq.answer;
                    return `<li><a href="#faq-${escapeHtml(faq.id)}" data-faq="${escapeHtml(faq.id)}">
                                <strong>${escapeHtml(faq.question)}</strong>
                                <span>${escapeHtml(preview)}</span>
                            </a></li>`;
                }).join('');
            }

            let debounce;
            askInput.addEventListener('input', () => {
                clearTimeout(debounce);
                debounce = setTimeout(() => renderSuggestions(askInput.value), 200);
            });

            suggestList.addEventListener('click', event => {
                const link = event.target.closest('a[data-faq]');
                if (!link) return;
                event.preventDefault();
                openFaq(link.dataset.faq);
            });

            // ── Search + category filter for the FAQ list ──
            function setCategory(category) {
                activeCategory = category;
                chips.forEach(c => c.classList.toggle('active', c.dataset.category === category));
            }

            function applyFilter() {
                const query = normalise(filterInput.value);
                const terms = query ? query.split(' ') : [];
                let visibleCount = 0;

                items.forEach(item => {
                    const text = normalise(item.textContent);
                    const inCategory = activeCategory === 'all' || item.dataset.category === activeCategory;
                    const matches = terms.every(t => text.includes(t));
                    const show = inCategory && matches;
                    item.hidden = !show;
                    if (show) visibleCount++;
                    if (query && show) item.open = true;
                });

                groups.forEach(group => {
                    group.hidden = !group.querySelector('.faq-item:not([hidden])');
                });

                emptyMsg.hidden = visibleCount > 0;
            }

            chips.forEach(chip => chip.addEventListener('click', () => {
                setCategory(chip.dataset.category);
                applyFilter();
            }));

            filterInput.addEventListener('input', applyFilter);

            // Open the FAQ in the URL hash (e.g. /faq#faq-check-status)
            if (location.hash.startsWith('#faq-')) {
                openFaq(location.hash.slice(5));
            }

            // After submitting a question, show related FAQs for it
            if (ASKED) {
                renderSuggestions(ASKED);
            } else if (askInput.value) {
                renderSuggestions(askInput.value);
            }
        })();
    </script>
@endpush
