<?php

namespace App\Support;

use HTMLPurifier;
use HTMLPurifier_Config;

/**
 * Cleans HTML coming from the admin rich-text editor (Quill) so it is safe to
 * print on the public website with {!! !!}. Only basic formatting is kept.
 */
class RichText
{
    private static ?HTMLPurifier $purifier = null;

    public static function clean(?string $html): ?string
    {
        if ($html === null) {
            return null;
        }

        // Quill leaves "&nbsp;" between words; turn them back into normal spaces
        $html = str_replace(['&nbsp;', "\u{00A0}"], ' ', $html);
        $clean = trim(self::purifier()->purify($html));

        // An "empty" editor still sends <p><br></p>
        return self::isEmpty($clean) ? null : $clean;
    }

    public static function isEmpty(?string $html): bool
    {
        return trim(strip_tags((string) $html)) === '';
    }

    private static function purifier(): HTMLPurifier
    {
        if (self::$purifier) {
            return self::$purifier;
        }

        $cacheDir = storage_path('framework/cache/htmlpurifier');
        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir, 0755, true);
        }

        $config = HTMLPurifier_Config::createDefault();
        $config->set('Core.Encoding', 'UTF-8');
        $config->set('Cache.SerializerPath', $cacheDir);
        $config->set('HTML.Allowed', implode(',', [
            'p[class]', 'br', 'strong', 'b', 'em', 'i', 'u', 's',
            'h2[class]', 'h3[class]', 'h4[class]',
            'ul', 'ol', 'li[class]', 'blockquote[class]',
            'a[href|target|rel]',
        ]));
        // Text alignment from the editor toolbar
        $config->set('Attr.AllowedClasses', ['ql-align-center', 'ql-align-right', 'ql-align-justify']);
        $config->set('Attr.AllowedFrameTargets', ['_blank']);
        $config->set('HTML.TargetBlank', true);
        $config->set('HTML.TargetNoopener', true);
        $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true, 'tel' => true]);
        $config->set('AutoFormat.RemoveEmpty', true);

        return self::$purifier = new HTMLPurifier($config);
    }
}
