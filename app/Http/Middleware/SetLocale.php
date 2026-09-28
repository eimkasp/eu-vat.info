<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * Locale is determined solely by the URL prefix.
     * Non-prefixed URLs always resolve to the default language (English).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supported = array_keys(config('translation.supported_languages', []));
        $default = config('translation.default_language', 'en');

        // 1. Check URL prefix (e.g. /de/vat-calculator)
        $segment = $request->segment(1);

        if ($segment && in_array($segment, $supported) && $segment !== $default) {
            // Explicit locale prefix in URL — use it
            $locale = $segment;
        } else {
            // No locale prefix — always use the default language (English).
            // Non-prefixed URLs are the English routes; users wanting another
            // language must use the prefixed URL (e.g. /de, /fr).
            $locale = $default;
        }

        App::setLocale($locale);

        // Persist to session
        if ($request->hasSession()) {
            $request->session()->put('locale', $locale);
        }

        // Set the URL default for locale-aware route generation
        URL::defaults(['locale' => $locale === $default ? null : $locale]);

        return $next($request);
    }
}
