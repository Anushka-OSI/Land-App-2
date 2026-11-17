<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Support\Languages;
use App\Support\RichText;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Validation for the English / Sinhala / Tamil tabs on the News & Notices and Events forms.
 * - Fill in at least one language.
 * - A language that has anything typed in needs both a title and a short description.
 */
trait ValidatesTranslations
{
    protected function translationRules(): array
    {
        $rules = [];
        foreach (Languages::codes() as $lang) {
            $rules["title_{$lang}"] = 'nullable|string|max:255';
            $rules["excerpt_{$lang}"] = 'nullable|string|max:500';
            $rules["body_{$lang}"] = 'nullable|string|max:200000';
        }

        return $rules;
    }

    protected function translationAttributes(): array
    {
        $names = [];
        foreach (Languages::ALL as $lang => $info) {
            $names["title_{$lang}"] = "{$info['label']} title";
            $names["excerpt_{$lang}"] = "{$info['label']} short description";
            $names["body_{$lang}"] = "{$info['label']} full story";
        }

        return $names;
    }

    /** Cleans the rich text and checks the rules above. Returns the title_xx/excerpt_xx/body_xx values. */
    protected function translatedData(array $validated): array
    {
        $data = [];
        $errors = [];
        $filledAny = false;

        foreach (Languages::ALL as $lang => $info) {
            $title = trim((string) ($validated["title_{$lang}"] ?? ''));
            $excerpt = trim((string) ($validated["excerpt_{$lang}"] ?? ''));
            $body = RichText::clean($validated["body_{$lang}"] ?? null);

            if ($title === '' && $excerpt === '' && $body === null) {
                $data += ["title_{$lang}" => null, "excerpt_{$lang}" => null, "body_{$lang}" => null];
                continue;
            }

            $filledAny = true;
            if ($title === '') {
                $errors["title_{$lang}"] = "Please add the {$info['label']} title (or clear the other {$info['label']} fields).";
            }
            if ($excerpt === '') {
                $errors["excerpt_{$lang}"] = "Please add the {$info['label']} short description.";
            }

            $data += ["title_{$lang}" => $title ?: null, "excerpt_{$lang}" => $excerpt ?: null, "body_{$lang}" => $body];
        }

        if (!$filledAny) {
            $errors['title_en'] = 'Please fill in at least one language (title and short description).';
        }

        if ($errors) {
            throw ValidationException::withMessages($errors);
        }

        return $data;
    }
}
