<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ValidatesTranslations;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Support\Languages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/** Admin → Events (each in English / Sinhala / Tamil, with up to 10 photos) */
class EventController extends Controller
{
    use ValidatesTranslations;

    public function index(Request $request)
    {
        $events = Event::query()
            ->with('images')
            ->withCount('images')
            ->when($request->filled('q'), fn ($q) => $q->searchTitle($request->q))
            ->when(in_array($request->language, Languages::codes(), true), fn ($q) => $q->inLanguage($request->language))
            ->orderByDesc('event_date')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.form', ['item' => new Event([
            'event_date' => now(),
            'is_published' => true,
        ])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, null);

        DB::transaction(function () use ($request, $data) {
            $event = Event::create($data);
            $this->storeImages($request, $event);
        });

        return redirect()->route('admin.events.index')->with('success', 'Event created.');
    }

    public function show(Event $event)
    {
        $event->load('images');

        return view('admin.events.show', ['item' => $event]);
    }

    public function edit(Event $event)
    {
        $event->load('images');

        return view('admin.events.form', ['item' => $event]);
    }

    public function update(Request $request, Event $event)
    {
        $data = $this->validated($request, $event);

        DB::transaction(function () use ($request, $event, $data) {
            $event->update($data);

            // Remove ticked images
            $removeIds = array_map('intval', (array) $request->input('remove_images', []));
            $event->images()->whereIn('id', $removeIds)->get()->each(function ($image) {
                $image->deleteFile();
                $image->delete();
            });

            $this->storeImages($request, $event);
        });

        return redirect()->route('admin.events.show', $event)->with('success', 'Event updated.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event deleted.');
    }

    /**
     * Photos are added per language tab: images_en[], images_si[], images_ta[].
     * Each language has its own photos (max 10, 10 MB each) and may have none.
     */
    private function validated(Request $request, ?Event $event): array
    {
        $rules = ['event_date' => 'required|date', 'remove_images' => 'nullable|array', 'remove_images.*' => 'integer'];
        $messages = [];
        foreach (Languages::ALL as $lang => $info) {
            $rules["images_{$lang}"] = 'nullable|array|max:' . Event::MAX_IMAGES;
            $rules["images_{$lang}.*"] = 'image|mimes:jpg,jpeg,png,webp,gif|max:' . Event::MAX_IMAGE_KB;
            $messages += [
                "images_{$lang}.max" => "You can upload up to " . Event::MAX_IMAGES . " {$info['label']} photos.",
                "images_{$lang}.*.image" => 'Each file must be an image.',
                "images_{$lang}.*.mimes" => 'Photos must be JPG, PNG, WEBP or GIF.',
                "images_{$lang}.*.max" => 'Each photo must be 10 MB or smaller.',
                "images_{$lang}.*.uploaded" => 'A photo failed to upload. Each photo must be 10 MB or smaller.',
            ];
        }

        $validated = $request->validate($this->translationRules() + $rules, $messages,
            $this->translationAttributes() + ['event_date' => 'date']);

        // Text checks (at least one language, title + short description) – collect with the photo checks below
        $errors = [];
        try {
            $data = $this->translatedData($validated);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            $data = null;
        }

        $removeIds = array_map('intval', (array) $request->input('remove_images', []));
        $existing = $event ? $event->images()->get(['id', 'language']) : collect();

        foreach (Languages::ALL as $lang => $info) {
            $kept = $existing->where('language', $lang)->whereNotIn('id', $removeIds)->count();
            $adding = count($request->file("images_{$lang}", []));

            if ($kept + $adding > Event::MAX_IMAGES) {
                $errors["images_{$lang}"] = ["The {$info['label']} tab can have at most " . Event::MAX_IMAGES
                    . " photos. It already has {$kept}, so you can add " . max(0, Event::MAX_IMAGES - $kept) . ' more.'];
            }

            // Photos only make sense for a language that is written
            $hasText = filled($request->input("title_{$lang}")) || filled($request->input("excerpt_{$lang}"));
            if ($kept + $adding > 0 && !$hasText && !isset($errors["title_{$lang}"])) {
                $errors["images_{$lang}"] = ["These photos are in the {$info['label']} tab, but there is no {$info['label']} title. "
                    . "Add the {$info['label']} title and short description, or remove the {$info['label']} photos."];
            }
        }

        if ($errors) {
            throw ValidationException::withMessages($errors);
        }

        $data['event_date'] = $validated['event_date'];
        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }

    private function storeImages(Request $request, Event $event): void
    {
        $order = (int) $event->images()->max('sort_order');

        foreach (Languages::codes() as $lang) {
            foreach ($request->file("images_{$lang}", []) as $file) {
                $event->images()->create([
                    'language' => $lang,
                    'path' => $file->store("events/{$event->id}", 'public'),
                    'sort_order' => ++$order,
                ]);
            }
        }
    }
}
