<?php

namespace App\Support;

use App\Models\SiteSetting;

/**
 * Head Office name, address, phone, fax, email and office hours.
 * Entered by the admin in Admin → Head Office → Office details and shown on the
 * Contact Us → Head Office and Contact Us → Inquiry pages. Nothing is shown until it has been entered.
 */
class HeadOfficeDetails
{
    /** Fields written in English, Sinhala and Tamil (stored as head_office.name_en, ...). */
    public const TEXT_FIELDS = ['name', 'address', 'hours'];

    /** Single-value fields. */
    public const CONTACT_FIELDS = ['phone', 'fax', 'email'];

    /** Map location (set with the map picker). */
    public const LOCATION_FIELDS = ['latitude', 'longitude'];

    private static ?array $cache = null;

    /** All setting keys, e.g. head_office.name_en, head_office.phone */
    public static function keys(): array
    {
        $keys = [];
        foreach (self::TEXT_FIELDS as $field) {
            foreach (Languages::codes() as $lang) {
                $keys[] = "head_office.{$field}_{$lang}";
            }
        }
        foreach ([...self::CONTACT_FIELDS, ...self::LOCATION_FIELDS] as $field) {
            $keys[] = "head_office.{$field}";
        }

        return $keys;
    }

    /** Raw values for the admin form: ['name_en' => ..., 'phone' => ...]. */
    public static function all(): array
    {
        if (self::$cache === null) {
            $values = SiteSetting::many(self::keys());
            self::$cache = [];
            foreach ($values as $key => $value) {
                self::$cache[substr($key, strlen('head_office.'))] = $value;
            }
        }

        return self::$cache;
    }

    /** Save values from the admin form (keys like name_en, phone). */
    public static function save(array $data): void
    {
        $values = [];
        foreach (self::keys() as $key) {
            $field = substr($key, strlen('head_office.'));
            $values[$key] = $data[$field] ?? null;
        }

        SiteSetting::putMany($values);
        self::$cache = null;
    }

    /** Name / address / hours in the visitor's language (English when that language is empty). */
    public static function text(string $field, ?string $lang = null): ?string
    {
        $lang ??= Languages::current();
        $all = self::all();

        return $all["{$field}_{$lang}"] ?: $all["{$field}_en"];
    }

    public static function contact(string $field): ?string
    {
        return self::all()[$field] ?? null;
    }

    /** [latitude, longitude] or null when no location has been set. */
    public static function location(): ?array
    {
        $all = self::all();

        return is_numeric($all['latitude'] ?? null) && is_numeric($all['longitude'] ?? null)
            ? [(float) $all['latitude'], (float) $all['longitude']]
            : null;
    }

    /** True once the admin has entered anything. */
    public static function isFilled(): bool
    {
        return collect(self::all())->filter()->isNotEmpty();
    }
}
