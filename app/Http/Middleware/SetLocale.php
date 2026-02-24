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
     * Locale priority: URL prefix > session > browser Accept-Language > default
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supported = array_keys(config('translation.supported_languages', []));
        $default = config('translation.default_language', 'en');

        // 1. Check URL prefix (e.g. /de/vat-calculator)
        $segment = $request->segment(1);

        if ($segment && in_array($segment, $supported) && $segment !== $default) {
            $locale = $segment;
        } elseif ($request->hasSession() && $request->session()->has('locale') && in_array($request->session()->get('locale'), $supported)) {
            // 2. Check session
            $locale = $request->session()->get('locale');
        } else {
            // 3. Check browser Accept-Language
            $locale = $this->detectBrowserLocale($request, $supported) ?? $default;
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

    /**
     * Parse Accept-Language header and find best supported match.
     */
    private function detectBrowserLocale(Request $request, array $supported): ?string
    {
        $acceptLanguage = $request->header('Accept-Language', '');

        if (empty($acceptLanguage)) {
            return null;
        }

        // Parse "en-US,en;q=0.9,de;q=0.8" into sorted array
        $locales = [];
        foreach (explode(',', $acceptLanguage) as $part) {
            $parts = explode(';q=', trim($part));
            $lang = strtolower(substr(trim($parts[0]), 0, 2));
            $quality = isset($parts[1]) ? (float) $parts[1] : 1.0;
            $locales[$lang] = $quality;
        }

        arsort($locales);

        foreach (array_keys($locales) as $lang) {
            if (in_array($lang, $supported)) {
                return $lang;
            }
        }

        return null;
    }
}
