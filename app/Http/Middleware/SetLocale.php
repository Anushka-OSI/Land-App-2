<?php

namespace App\Http\Middleware;

use App\Support\Languages;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Shows the website in the language the visitor chose (English, Sinhala or Tamil).
 *
 *  - Choosing a language: any page with ?lang=si|ta|en (the first-visit chooser and the
 *    language switcher link to this). The choice is saved in the session and in a cookie
 *    for a year, then the visitor is redirected to the same page without ?lang. Any
 *    ?read=xx (per-article "Read in:" choice) is removed as well, so the article switches
 *    to the newly chosen language.
 *  - Until a language has been chosen, $languageChosen is false and the layout shows the
 *    full-screen language chooser.
 *  - The admin panel always stays in English.
 */
class SetLocale
{
    public const COOKIE = 'site_language';
    private const COOKIE_MINUTES = 60 * 24 * 365;

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('admin', 'admin/*')) {
            $this->apply('en');
            View::share('languageChosen', true);

            return $next($request);
        }

        $requested = $request->query('lang');

        if (Languages::isValid($requested)) {
            $request->session()->put('locale', $requested);
            Cookie::queue(self::COOKIE, $requested, self::COOKIE_MINUTES);

            // Normal page visit: reload the same page without ?lang so links stay clean.
            // ?read (the "Read in:" switch on a News / Event page) is dropped too, so the
            // content follows the language the visitor has just chosen for the whole site.
            if ($request->isMethod('GET') && !$request->expectsJson()) {
                return redirect()->to($request->fullUrlWithoutQuery(['lang', 'read']));
            }
        }

        $chosen = collect([$requested, $request->session()->get('locale'), $request->cookie(self::COOKIE)])
            ->first(fn ($code) => Languages::isValid($code));

        if ($chosen && $request->session()->get('locale') !== $chosen) {
            $request->session()->put('locale', $chosen);
        }

        $this->apply($chosen ?? config('app.locale'));
        View::share('languageChosen', $chosen !== null);

        return $next($request);
    }

    private function apply(string $locale): void
    {
        App::setLocale($locale);
        Carbon::setLocale($locale);
    }
}
