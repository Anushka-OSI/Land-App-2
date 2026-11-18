<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Support\Languages;
use Illuminate\Validation\ValidationException;

/**
 * Content must be added in all three languages (English, Sinhala and Tamil).
 *
 *   $this->checkAllLanguages($data, [
 *       'Question' => ['en' => 'question', 'si' => 'question_si', 'ta' => 'question_ta'],
 *   ], [
 *       'Position' => [...],   // optional, but when filled in one language it is needed in all three
 *   ]);
 *
 * Throws a ValidationException with an error on every empty field, plus a 'languages' summary
 * ("Please add this content in all 3 languages – missing: Sinhala, Tamil") shown at the top of the form.
 */
trait RequiresAllLanguages
{
    protected function checkAllLanguages(array $data, array $required, array $allOrNone = []): void
    {
        $errors = [];
        $missing = [];

        $check = function (string $label, array $columns, bool $always) use ($data, &$errors, &$missing) {
            $filled = array_map(fn ($column) => filled(trim(strip_tags((string) ($data[$column] ?? '')))), $columns);

            if (! $always && ! in_array(true, $filled, true)) {
                return; // optional field left empty in every language
            }

            foreach ($columns as $lang => $column) {
                if (! $filled[$lang]) {
                    $name = Languages::ALL[$lang]['label'];
                    $errors[$column] = $always
                        ? "Please add the {$name} " . strtolower($label) . '.'
                        : "Please add the {$name} " . strtolower($label) . ' (it has been added in another language).';
                    $missing[$lang] = $name;
                }
            }
        };

        foreach ($required as $label => $columns) {
            $check($label, $columns, true);
        }
        foreach ($allOrNone as $label => $columns) {
            $check($label, $columns, false);
        }

        if ($errors) {
            throw ValidationException::withMessages($errors + ['languages' => self::languagesMessage($missing)]);
        }
    }

    /** "Please add this content in all 3 languages (English, Sinhala and Tamil). Missing: Sinhala, Tamil." */
    protected static function languagesMessage(array $missing): string
    {
        // in the usual order: English, Sinhala, Tamil
        $names = array_values(array_filter(
            array_map(fn ($code) => $missing[$code] ?? null, Languages::codes())
        ));

        return 'Please add this content in all 3 languages (English, Sinhala and Tamil). Missing: '
            . implode(', ', $names) . '.';
    }

    /** ['en' => 'title_en', 'si' => 'title_si', 'ta' => 'title_ta'] */
    protected static function suffixedColumns(string $field): array
    {
        return array_combine(Languages::codes(), array_map(fn ($lang) => "{$field}_{$lang}", Languages::codes()));
    }

    /** ['en' => 'question', 'si' => 'question_si', 'ta' => 'question_ta'] (English has no suffix) */
    protected static function englishBaseColumns(string $field): array
    {
        return array_combine(Languages::codes(),
            array_map(fn ($lang) => $lang === 'en' ? $field : "{$field}_{$lang}", Languages::codes()));
    }
}
