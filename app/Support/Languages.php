<?php

namespace App\Support;

/**
 * Languages the website is available in.
 * The visitor's choice is applied to every page by App\Http\Middleware\SetLocale.
 */
class Languages
{
    public const ALL = [
        'en' => ['label' => 'English', 'native' => 'English', 'short' => 'EN'],
        'si' => ['label' => 'Sinhala', 'native' => 'සිංහල',   'short' => 'සිං'],
        'ta' => ['label' => 'Tamil',   'native' => 'தமிழ்',    'short' => 'த'],
    ];

    /** Order used in language switchers (Sinhala, Tamil, English – as on Sri Lankan government sites). */
    public const DISPLAY_ORDER = ['si', 'ta', 'en'];

    public static function codes(): array
    {
        return array_keys(self::ALL);
    }

    public static function isValid(mixed $code): bool
    {
        return is_string($code) && array_key_exists($code, self::ALL);
    }

    public static function label(?string $code): string
    {
        $lang = self::ALL[$code] ?? self::ALL['en'];

        return $lang['native'] === $lang['label'] ? $lang['label'] : "{$lang['native']} ({$lang['label']})";
    }

    public static function native(?string $code): string
    {
        return (self::ALL[$code] ?? self::ALL['en'])['native'];
    }

    /** Language the current page is shown in. */
    public static function current(): string
    {
        $locale = app()->getLocale();

        return self::isValid($locale) ? $locale : 'en';
    }

    /** URL of the current page in another language (handled by SetLocale). */
    public static function switchUrl(string $code): string
    {
        return request()->fullUrlWithQuery(['lang' => $code]);
    }
}
