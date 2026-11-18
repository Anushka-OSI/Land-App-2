@extends('layouts.app')

@section('title', __('Find Settlement | Department of Land Title Settlement'))

@section('content')

    {{-- Banner --}}
    @include('partials.page-banner', [
        'title' => __('Find Land Settlement'),
        'subtitle' => __('Search the national registry for your land settlement records and title status'),
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
                            {{ __('Land Record Search') }}</h2>
                        <p style="color: var(--gray-600); font-size: 1.05rem;">{{ __('Enter the cadastral details below to find the current settlement stage') }}</p>
                    </div>

                    <form id="find-form" novalidate>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">

                            <div>
                                <label for="map_no"
                                    style="display:block; font-family:var(--font-accent); font-weight:600; font-size:0.85rem; color:var(--gray-700); margin-bottom:0.5rem; text-transform:uppercase; letter-spacing:0.05em;">{{ __('Map Number') }}</label>
                                <input type="text" id="map_no" name="map_no" class="form-control" autocomplete="off" placeholder="{{ __('e.g. 52') }}"
                                    style="width:100%; padding:0.85rem 1rem; border:1px solid var(--gray-200); border-radius:var(--radius-md); font-family:var(--font-body); outline:none; transition:var(--transition-fast);">
                                <small class="field-error" data-error-for="map_no"></small>
                            </div>

                            <div>
                                <label for="block_no"
                                    style="display:block; font-family:var(--font-accent); font-weight:600; font-size:0.85rem; color:var(--gray-700); margin-bottom:0.5rem; text-transform:uppercase; letter-spacing:0.05em;">{{ __('Block Number') }}</label>
                                <input type="text" id="block_no" name="block_no" class="form-control" autocomplete="off" placeholder="{{ __('e.g. 04') }}"
                                    style="width:100%; padding:0.85rem 1rem; border:1px solid var(--gray-200); border-radius:var(--radius-md); font-family:var(--font-body); outline:none; transition:var(--transition-fast);">
                                <small class="field-error" data-error-for="block_no"></small>
                            </div>

                            <div>
                                <label for="sheet_no"
                                    style="display:block; font-family:var(--font-accent); font-weight:600; font-size:0.85rem; color:var(--gray-700); margin-bottom:0.5rem; text-transform:uppercase; letter-spacing:0.05em;">{{ __('Sheet Number') }}</label>
                                <input type="text" id="sheet_no" name="sheet_no" class="form-control" autocomplete="off" placeholder="{{ __('e.g. 12') }}"
                                    style="width:100%; padding:0.85rem 1rem; border:1px solid var(--gray-200); border-radius:var(--radius-md); font-family:var(--font-body); outline:none; transition:var(--transition-fast);">
                                <small class="field-error" data-error-for="sheet_no"></small>
                            </div>

                            <div>
                                <label for="lot_no"
                                    style="display:block; font-family:var(--font-accent); font-weight:600; font-size:0.85rem; color:var(--gray-700); margin-bottom:0.5rem; text-transform:uppercase; letter-spacing:0.05em;">{{ __('Lot No.') }}</label>
                                <input type="text" id="lot_no" name="lot_no" class="form-control" autocomplete="off" placeholder="{{ __('e.g. 1045') }}"
                                    style="width:100%; padding:0.85rem 1rem; border:1px solid var(--gray-200); border-radius:var(--radius-md); font-family:var(--font-body); outline:none; transition:var(--transition-fast);">
                                <small class="field-error" data-error-for="lot_no"></small>
                            </div>

                            {{-- Optional: only show the record with this file number --}}
                            <div style="grid-column: 1 / -1;">
                                <label for="file_no"
                                    style="display:block; font-family:var(--font-accent); font-weight:600; font-size:0.85rem; color:var(--gray-700); margin-bottom:0.5rem; text-transform:uppercase; letter-spacing:0.05em;">{{ __('File No.') }}
                                    <span style="text-transform:none; letter-spacing:0; font-weight:500; color:var(--gray-500);">({{ __('optional') }})</span></label>
                                <input type="text" id="file_no" name="file_no" class="form-control" autocomplete="off" maxlength="100" placeholder="{{ __('e.g. LTS/KAN/2024/015') }}"
                                    style="width:100%; padding:0.85rem 1rem; border:1px solid var(--gray-200); border-radius:var(--radius-md); font-family:var(--font-body); outline:none; transition:var(--transition-fast);">
                                <small class="field-error" data-error-for="file_no"></small>
                                <small style="display:block; margin-top:.35rem; color:var(--gray-500); font-size:.82rem;">{{ __('If you know the file number, enter it to make sure the record shown is for your file.') }}</small>
                            </div>

                        </div>

                        <div style="text-align: center;">
                            <button type="submit" id="find-submit" class="btn btn-primary"
                                style="padding: 1rem 3rem; font-size: 1.1rem; width: 100%; justify-content: center;">
                                <span class="btn-label">{{ __('Search Records') }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" style="width:20px; height:20px; margin-left:0.5rem;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </form>

                </div>

                {{-- Results Section (filled by JavaScript) --}}
                <div id="results" aria-live="polite"></div>

            </div>
        </div>
    </div>

    <style>
        .form-control.is-invalid {
            border-color: #dc2626 !important;
        }

        .field-error {
            display: block;
            margin-top: 0.35rem;
            font-size: 0.8rem;
            color: #dc2626;
        }

        .result-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        @media (max-width: 640px) {
            .result-grid {
                grid-template-columns: 1fr;
            }
        }

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
        .result-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-md);
            padding: 3rem;
            animation: fadeInUp 0.5s ease both;
        }

        .result-card + .result-card {
            margin-top: 1.5rem;
        }

        .result-card.success {
            border: 1px solid var(--green-100);
        }

        .result-card.error {
            border: 1px solid #fee2e2;
            text-align: center;
        }

        .result-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            border-bottom: 1px solid var(--gray-100);
            padding-bottom: 1.5rem;
        }

        .result-icon {
            width: 52px;
            height: 52px;
            flex-shrink: 0;
            background: var(--green-50);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--green-600);
        }

        .result-icon svg {
            width: 28px;
            height: 28px;
        }

        .result-header h3 {
            font-family: var(--font-heading);
            color: var(--green-900);
            margin: 0;
            font-size: 1.6rem;
        }

        .result-header p {
            color: var(--gray-500);
            margin: 0;
            font-size: 0.9rem;
        }

        .result-label {
            display: block;
            font-family: var(--font-accent);
            font-size: 0.75rem;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
        }

        .result-value {
            color: var(--gray-800);
            font-size: 1.1rem;
            font-weight: 700;
            word-break: break-word;
        }

        .error-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            background: #fef2f2;
            color: #dc2626;
            border-radius: 50%;
            margin-bottom: 1.5rem;
        }

        .error-icon svg {
            width: 32px;
            height: 32px;
        }

        .result-card.error h3 {
            font-family: var(--font-heading);
            color: var(--gray-900);
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .result-card.error p {
            color: var(--gray-600);
            margin: 0;
        }

        #find-submit:disabled {
            opacity: 0.75;
            cursor: wait;
        }

        .field-error:empty {
            display: none;
        }
    </style>

@endsection

@push('scripts')
    @php
        $findText = [
                'recordFound' => __('Record Found'),
                'recordOf' => __('Record :n of :total'),
                'unexpected' => __('The server returned an unexpected response (HTTP :status).'),
                'nicSubtitle' => __('Land records for NIC :nic'),
                'nicNotFound' => __('We couldn\'t find any land records for NIC :nic.'),
                'fileNoNotFound' => __('A record was not found for File No :file with these Map, Block, Sheet and Lot numbers. Please check the File No, or search without it.'),
            ];
    @endphp
    <script>
        (function () {
            // Our Laravel endpoint, which calls the eTitle API
            // (http://etitle.landsettledept.gov.lk/get-form14-get-record/{map}/{block}/{sheetno}/{lotno})
            const SEARCH_URL = @json(route('find.search'));
            const NIC_SEARCH_URL = @json(route('find.search-nic'));

            const form = document.getElementById('find-form');
            const submitBtn = document.getElementById('find-submit');
            const results = document.getElementById('results');
            // Text with placeholders, in the visitor's language
            const T = @json($findText);

            const fields = {
                map_no: @json(__('Please enter the Map Number.')),
                block_no: @json(__('Please enter the Block Number.')),
                sheet_no: @json(__('Please enter the Sheet Number.')),
                lot_no: @json(__('Please enter the Lot Number.')),
            };

            const ICON_OK = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
            const ICON_ERR = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';

            function escapeHtml(value) {
                return String(value)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#39;');
            }

            // Fields shown on the result card: [API field, label]. Add/remove lines to change what is displayed.
            const DISPLAY_FIELDS = [
                ['map_no', @json(__('Map No'))],
                ['block_no', @json(__('Block No'))],
                ['sheet_number', @json(__('Sheet No'))],
                ['lot_no', @json(__('Lot No'))],
                ['file_no', @json(__('File No'))],
                ['current_stage', @json(__('Current Stage'))],
                ['owner_names', @json(__('Owner Name'))],
                ['owner_sizes', @json(__('Land Size'))],
                ['ownership_type', @json(__('Ownership Type'))],
                ['type', @json(__('Land Type'))],
                ['sub_type', @json(__('Sub Type'))],
                ['gazette_no', @json(__('Gazette No'))],
                ['gazette_date', @json(__('Gazette Date'))],
                // ['certificate_number', 'Certificate No'],    
            ];

            // Value of one field; the file number may be in file_no or file_code
            function fieldValue(record, key) {
                if (key === 'file_no') return record.file_no || record.file_code;
                return record[key];
            }

            function toText(value) {
                if (value === null || value === undefined || value === '') return '—';
                if (typeof value === 'object') return JSON.stringify(value);
                return value;
            }

            function setLoading(loading) {
                submitBtn.disabled = loading;
                submitBtn.querySelector('.btn-label').textContent = loading ? @json(__('Searching...')) : @json(__('Search Records'));
            }

            function showError(title, message) {
                results.innerHTML = `
                    <div class="result-card error">
                        <div class="error-icon">${ICON_ERR}</div>
                        <h3>${escapeHtml(title)}</h3>
                        <p>${escapeHtml(message)}</p>
                    </div>`;
            }

            function showRecords(records, subtitle) {
                results.innerHTML = records.map((record, i) => `
                    <div class="result-card success">
                        <div class="result-header">
                            <div class="result-icon">${ICON_OK}</div>
                            <div>
                                <h3>${escapeHtml(T.recordFound)}</h3>
                                <p>${escapeHtml(subtitle)}${records.length > 1 ? ' · ' + escapeHtml(T.recordOf.replace(':n', i + 1).replace(':total', records.length)) : ''}</p>
                            </div>
                        </div>
                        <div class="result-grid">
                            ${DISPLAY_FIELDS.map(([key, label]) => `
                                <div>
                                    <span class="result-label">${escapeHtml(label)}</span>
                                    <span class="result-value">${escapeHtml(toText(fieldValue(record, key)))}</span>
                                </div>`).join('')}
                        </div>
                    </div>`).join('');
            }

            // Pull the record(s) out of the API response.
            // Found:     {"message":[{...record...}],"states":200}
            // Not found: {"message":"Data Not found..","states":500}
            function extractRecords(json) {
                if (!json || typeof json !== 'object') return [];
                if (Number(json.states) !== 200) return [];

                const data = json.message;
                const list = Array.isArray(data) ? data : [data];
                return list.filter(r => r && typeof r === 'object' && Object.keys(r).length > 0);
            }

            // GET `url` (one of our /find/search endpoints) and show the results.
            async function runSearch(url, { subtitle, notFound, onValidationError }) {
                const requestOptions = {
                    method: 'GET',
                    redirect: 'follow',
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                };

                setLoading(true);
                results.innerHTML = '';

                // Abort if no answer within 40 seconds
                const controller = new AbortController();
                const timer = setTimeout(() => controller.abort(), 40000);
                requestOptions.signal = controller.signal;

                try {
                    let response;
                    try {
                        response = await fetch(url, requestOptions);
                    } catch (networkError) {
                        // Our own server could not be reached, or timed out
                        console.error('Find land: request to', url, 'failed:', networkError);
                        if (networkError.name === 'AbortError') {
                            showError(@json(__('Request Timed Out')), @json(__('The land records service took too long to respond. Please try again later.')));
                        } else {
                            showError(@json(__('Connection Error')), @json(__('Unable to reach the server. Please check your connection and try again.')));
                        }
                        return;
                    }

                    const text = await response.text();
                    console.log('Find land: GET', url, '→', response.status, text);

                    let json;
                    try {
                        json = JSON.parse(text);
                    } catch (parseError) {
                        showError(@json(__('Invalid Response')), T.unexpected.replace(':status', response.status));
                        return;
                    }

                    // Server-side validation errors
                    if (response.status === 422 && json.errors) {
                        onValidationError(json.errors);
                        return;
                    }

                    if (response.status === 429) {
                        showError(@json(__('Too Many Requests')), @json(__('Please wait a moment before searching again.')));
                        return;
                    }

                    if (response.status === 501) {
                        showError(@json(__('Not Available')), json.message);
                        return;
                    }

                    // eTitle API unreachable (503) or returned a bad response (502)
                    if (!response.ok) {
                        showError(@json(__('Service Unavailable')), json.message || @json(__('Unable to reach the land records service. Please try again later.')));
                        return;
                    }

                    const records = extractRecords(json);

                    if (records.length === 0) {
                        showError(@json(__('No Records Found')), notFound);
                    } else {
                        showRecords(records, subtitle);
                    }
                } finally {
                    clearTimeout(timer);
                    setLoading(false);
                    results.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            }

            // Search by Map / Block / Sheet / Lot (the form on this page)
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                // Validate: every field is required
                const values = {};
                let hasError = false;
                Object.entries(fields).forEach(([name, message]) => {
                    const input = document.getElementById(name);
                    const errorEl = form.querySelector(`[data-error-for="${name}"]`);
                    values[name] = input.value.trim();

                    if (!values[name]) {
                        input.classList.add('is-invalid');
                        errorEl.textContent = message;
                        hasError = true;
                    } else {
                        input.classList.remove('is-invalid');
                        errorEl.textContent = '';
                    }
                });
                if (hasError) {
                    results.innerHTML = '';
                    return;
                }

                // Optional file number
                const fileInput = document.getElementById('file_no');
                fileInput.classList.remove('is-invalid');
                form.querySelector('[data-error-for="file_no"]').textContent = '';
                const fileNo = fileInput.value.trim();
                if (fileNo) values.file_no = fileNo;

                // e.g. /find/search?map_no=120036&block_no=1&sheet_no=2&lot_no=70
                runSearch(`${SEARCH_URL}?${new URLSearchParams(values).toString()}`, {
                    subtitle: @json(__('Details matching your criteria')),
                    notFound: fileNo
                        ? T.fileNoNotFound.replace(':file', fileNo)
                        : @json(__('We couldn\'t find any settlement records matching those details. Please check your inputs and try again.')),
                    onValidationError(errors) {
                        Object.entries(errors).forEach(([name, messages]) => {
                            const input = document.getElementById(name);
                            const errorEl = form.querySelector(`[data-error-for="${name}"]`);
                            if (input) input.classList.add('is-invalid');
                            if (errorEl) errorEl.textContent = messages[0];
                        });
                    },
                });
            });

            // Search by NIC: the homepage search bar opens /find?nic=...
            const nic = (new URLSearchParams(window.location.search).get('nic') || '').trim().toUpperCase();
            if (nic) {
                runSearch(`${NIC_SEARCH_URL}?${new URLSearchParams({ nic }).toString()}`, {
                    subtitle: T.nicSubtitle.replace(':nic', nic),
                    notFound: T.nicNotFound.replace(':nic', nic),
                    onValidationError(errors) {
                        showError(@json(__('Invalid NIC')), (errors.nic || [@json(__('Please enter a valid NIC number.'))])[0]);
                    },
                });
            }
        })();
    </script>
@endpush
