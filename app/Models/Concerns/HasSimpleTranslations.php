<?php

namespace App\Models\Concerns;

/**
 * English text in `field`, optional Sinhala / Tamil in `field_si` / `field_ta`.
 * When a translation is empty the site's translation files are tried, then the English text is shown.
 */
trait HasSimpleTranslations
{
    public function textIn(string $field, ?string $lang = null): ?string
    {
        $lang ??= app()->getLocale();
        $english = $this->getAttribute($field);

        if ($lang === 'en' || blank($english)) {
            return $english;
        }

        return $this->getAttribute("{$field}_{$lang}") ?: __($english);
    }
}
