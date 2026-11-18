<?php

namespace App\Models;

use App\Models\Concerns\HasSimpleTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/** A district office (Contact Us → Regional Offices). Managed in Admin → Regional Offices. */
class RegionalOffice extends Model
{
    use HasSimpleTranslations;

    /** Provinces of Sri Lanka, in the order shown on the website. Labels are translated with __(). */
    public const PROVINCES = [
        'western'       => 'Western Province',
        'central'       => 'Central Province',
        'southern'      => 'Southern Province',
        'northern'      => 'Northern Province',
        'eastern'       => 'Eastern Province',
        'north_western' => 'North Western Province',
        'north_central' => 'North Central Province',
        'uva'           => 'Uva Province',
        'sabaragamuwa'  => 'Sabaragamuwa Province',
    ];

    protected $fillable = [
        'province',
        'name', 'name_si', 'name_ta',
        'address', 'address_si', 'address_ta',
        'phone', 'email',
        'latitude', 'longitude',
        'sort_order', 'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
        'sort_order' => 'integer',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->ordered();
    }

    /** Province order, then display order inside the province. */
    public function scopeOrdered(Builder $query): Builder
    {
        $keys = array_keys(self::PROVINCES);
        $cases = collect($keys)->map(fn ($key, $i) => "WHEN '{$key}' THEN {$i}")->implode(' ');

        return $query->orderByRaw("CASE province {$cases} ELSE 99 END")->orderBy('sort_order')->orderBy('id');
    }

    public function hasLocation(): bool
    {
        return $this->latitude !== null && $this->longitude !== null;
    }

    /** id of this office's card on Contact Us → Regional Offices (the homepage map links to it). */
    public function anchor(): string
    {
        return 'office-' . $this->id;
    }

    /** Province name in English (admin panel). */
    public function getProvinceLabelAttribute(): string
    {
        return self::PROVINCES[$this->province] ?? ucfirst((string) $this->province);
    }
}
