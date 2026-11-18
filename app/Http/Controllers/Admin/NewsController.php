<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ValidatesTranslations;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsDocument;
use App\Support\Languages;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use RuntimeException;

/** Admin → News & Notices (each item in English / Sinhala / Tamil, with optional documents) */
class NewsController extends Controller
{
    use ValidatesTranslations;

    public function index(Request $request)
    {
        $news = News::query()
            ->withCount('documents')
            ->when($request->filled('q'), fn ($q) => $q->searchTitle($request->q))
            ->when(in_array($request->language, Languages::codes(), true), fn ($q) => $q->inLanguage($request->language))
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.form', ['item' => new News([
            'published_at' => now(),
            'is_published' => true,
        ])]);
    }

    public function store(Request $request)
    {
        [$data, $documents] = $this->validated($request);

        DB::transaction(function () use ($request, $data, $documents) {
            $news = News::create($data);
            $this->saveDocuments($request, $news, $documents);
        });

        return redirect()->route('admin.news.index')->with('success', 'News item created.');
    }

    public function show(News $news)
    {
        $news->load('documents');

        return view('admin.news.show', ['item' => $news]);
    }

    public function edit(News $news)
    {
        $news->load('documents');

        return view('admin.news.form', ['item' => $news]);
    }

    public function update(Request $request, News $news)
    {
        [$data, $documents] = $this->validated($request, $news);

        DB::transaction(function () use ($request, $news, $data, $documents) {
            $news->update($data);
            $this->saveDocuments($request, $news, $documents);
        });

        return redirect()->route('admin.news.show', $news)->with('success', 'News item updated.');
    }

    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'News item deleted.');
    }

    /** @return array{0: array, 1: array} [news columns, document changes] */
    private function validated(Request $request, ?News $news = null): array
    {
        $languages = Rule::in(Languages::codes());

        $validated = $request->validate(
            $this->translationRules() + [
                'published_at' => 'required|date',

                // New documents, with a name and language for each (same order as the files)
                'documents' => 'nullable|array|max:' . NewsDocument::MAX_DOCUMENTS,
                'documents.*' => [
                    'file',
                    'max:' . NewsDocument::MAX_KB,
                    'extensions:' . implode(',', array_keys(NewsDocument::TYPES)),
                    $this->notScriptOrWebPage(),
                ],
                'new_document_names' => 'nullable|array',
                'new_document_names.*' => 'nullable|string|max:255',
                'new_document_languages' => 'nullable|array',
                'new_document_languages.*' => ['nullable', $languages],

                // Documents already attached: rename, change language, remove
                'document_names' => 'nullable|array',
                'document_names.*' => 'nullable|string|max:255',
                'document_languages' => 'nullable|array',
                'document_languages.*' => ['nullable', $languages],
                'remove_documents' => 'nullable|array',
                'remove_documents.*' => 'integer',
            ],
            [
                'documents.max' => 'You can attach up to ' . NewsDocument::MAX_DOCUMENTS . ' documents.',
                'documents.*.max' => 'Each document must be 10 MB or smaller.',
                'documents.*.uploaded' => 'A document failed to upload. Each document must be 10 MB or smaller.',
                'documents.*.extensions' => 'Documents must be PDF, Word, Excel, PowerPoint, OpenDocument, text, JPG or PNG files.',
            ],
            $this->translationAttributes() + ['published_at' => 'date', 'documents.*' => 'document']
        );

        $data = $this->translatedData($validated) + [
            'published_at' => $validated['published_at'],
            'is_published' => $request->boolean('is_published'),
        ];

        $remove = array_map('intval', $validated['remove_documents'] ?? []);
        $kept = $news ? $news->documents()->whereNotIn('id', $remove)->count() : 0;
        $adding = count($validated['documents'] ?? []);

        if ($kept + $adding > NewsDocument::MAX_DOCUMENTS) {
            throw ValidationException::withMessages([
                'documents' => 'A news item can have at most ' . NewsDocument::MAX_DOCUMENTS . " documents. It already has {$kept}, so you can add "
                    . max(0, NewsDocument::MAX_DOCUMENTS - $kept) . ' more.',
            ]);
        }

        return [$data, [
            'remove' => $remove,
            'names' => $validated['document_names'] ?? [],
            'languages' => $validated['document_languages'] ?? [],
            'new_names' => array_values($validated['new_document_names'] ?? []),
            'new_languages' => array_values($validated['new_document_languages'] ?? []),
        ]];
    }

    private function saveDocuments(Request $request, News $news, array $changes): void
    {
        // Remove ticked documents
        $news->documents()->whereIn('id', $changes['remove'])->get()->each(function (NewsDocument $document) {
            $document->deleteFile();
            $document->delete();
        });

        // Rename / change the language of the others
        foreach ($news->documents()->get() as $document) {
            $name = trim((string) ($changes['names'][$document->id] ?? ''));
            $document->update([
                'name' => $name !== '' ? $name : $document->name,
                'language' => array_key_exists($document->id, $changes['languages'])
                    ? ($changes['languages'][$document->id] ?: null)
                    : $document->language,
            ]);
        }

        // Add new documents
        $order = (int) $news->documents()->max('sort_order');

        foreach (array_values($request->file('documents', [])) as $i => $file) {
            /** @var UploadedFile $file */
            $extension = strtolower($file->getClientOriginalExtension());
            $original = $file->getClientOriginalName();
            $name = trim((string) ($changes['new_names'][$i] ?? ''));

            // Random file name on the private disk; the original name is kept for the admin
            $path = $file->storeAs("news-documents/{$news->id}", Str::random(40) . '.' . $extension, NewsDocument::DISK);
            if ($path === false) {
                throw new RuntimeException('Could not save the document ' . $original . '.');
            }

            $news->documents()->create([
                'language' => ($changes['new_languages'][$i] ?? null) ?: null,
                'name' => $name !== '' ? $name : (pathinfo($original, PATHINFO_FILENAME) ?: 'Document'),
                'original_name' => $original,
                'path' => $path,
                'extension' => $extension,
                'size' => $file->getSize(),
                'sort_order' => $order += 10,
            ]);
        }
    }

    /** Refuse web pages, scripts and programs even when renamed to an allowed extension. */
    private function notScriptOrWebPage(): Closure
    {
        return function (string $attribute, mixed $file, Closure $fail) {
            if (! $file instanceof UploadedFile) {
                return;
            }

            $mime = strtolower((string) $file->getMimeType());
            $blocked = ['text/html', 'image/svg', 'application/xhtml', 'text/javascript', 'application/javascript',
                'application/x-php', 'text/x-php', 'application/x-dosexec', 'application/x-msdownload', 'application/x-executable',
                'application/x-sh', 'text/x-shellscript'];

            foreach ($blocked as $type) {
                if (str_starts_with($mime, $type)) {
                    $fail('This file type is not allowed.');

                    return;
                }
            }
        };
    }
}
