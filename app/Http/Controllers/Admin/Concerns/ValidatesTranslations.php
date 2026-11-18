<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Support\Languages;
use App\Support\RichText;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Validation for the English / Sinhala / Tamil tabs on the News & Notices and Events forms.
 * - Every item must be added in all three languages: title and short description in each.
 * - The full story is optional, but when it is written in one language it is needed in all three.
 */
trait ValidatesTranslations
{
    use RequiresAllLanguages;

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

        foreach (Languages::codes() as $lang) {
            $title = trim((string) ($validated["title_{$lang}"] ?? ''));
            $excerpt = trim((string) ($validated["excerpt_{$lang}"] ?? ''));

            $data += [
                "title_{$lang}" => $title ?: null,
                "excerpt_{$lang}" => $excerpt ?: null,
                "body_{$lang}" => RichText::clean($validated["body_{$lang}"] ?? null),
            ];
        }

        $this->checkAllLanguages($data, [
            'Title' => self::suffixedColumns('title'),
            'Short description' => self::suffixedColumns('excerpt'),
        ], [
            'Full story' => self::suffixedColumns('body'),
        ]);

        return $data;
    }
}
