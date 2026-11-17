<?php

namespace App\Models\Concerns;

use App\Support\Languages;
use Illuminate\Database\Eloquent\Builder;

/**
 * Content written in up to three languages: title_en / title_si / title_ta, excerpt_xx, body_xx.
 * A language "exists" for an item when its title is filled in.
 * When a language is missing, English is shown, then Sinhala, then Tamil.
 */
trait HasTranslations
{
    public static function translatableFields(): array
    {
        return ['title', 'excerpt', 'body'];
    }

    /** Columns for $fillable, e.g. title_en, excerpt_en, body_en, title_si ... */
    public static function translatableColumns(): array
    {
        $columns = [];
        foreach (Languages::codes() as $lang) {
            foreach (static::translatableFields() as $field) {
                $columns[] = "{$field}_{$lang}";
            }
        }

        return $columns;
    }

    public function hasLanguage(string $lang): bool
    {
        return filled($this->getAttribute("title_{$lang}"));
    }

    /** e.g. ['en', 'si'] */
    public function availableLanguages(): array
    {
        return array_values(array_filter(Languages::codes(), fn ($lang) => $this->hasLanguage($lang)));
    }

    /** The language that will actually be shown when $preferred is requested. */
    public function displayLanguage(?string $preferred = null): string
    {
        if ($preferred && $this->hasLanguage($preferred)) {
            return $preferred;
        }

        return $this->availableLanguages()[0] ?? 'en';
    }

    /** Translated field with fallback: $item->t('title', 'si') */
    public function t(string $field, ?string $lang = null): ?string
    {
        return $this->getAttribute($field . '_' . $this->displayLanguage($lang));
    }

    // $item->title / ->excerpt / ->body → best available language (English first)
    public function getTitleAttribute(): ?string
    {
        return $this->t('title');
    }

    public function getExcerptAttribute(): ?string
    {
        return $this->t('excerpt');
    }

    public function getBodyAttribute(): ?string
    {
        return $this->t('body');
    }

    /** Items that have content in $lang. */
    public function scopeInLanguage(Builder $query, string $lang): Builder
    {
        return $query->whereNotNull("title_{$lang}")->where("title_{$lang}", '!=', '');
    }

    /** Search the title in every language. */
    public function scopeSearchTitle(Builder $query, string $term): Builder
    {
        return $query->where(function (Builder $q) use ($term) {
            foreach (Languages::codes() as $lang) {
                $q->orWhere("title_{$lang}", 'like', '%' . $term . '%');
            }
        });
    }
}
