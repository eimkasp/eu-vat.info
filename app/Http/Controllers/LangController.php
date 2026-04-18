<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LangController extends Controller
{
    /**
     * Switch the active locale and redirect back to the equivalent page.
     */
    public function switch(Request $request, string $locale): RedirectResponse
    {
        $supported = array_keys(config('translation.supported_languages', []));

        if (! in_array($locale, $supported)) {
            abort(404);
        }

        session()->put('locale', $locale);

        $parsed  = parse_url(url()->previous());
        $path    = $parsed['path'] ?? '/';
        $default = config('translation.default_language', 'en');

        // Strip any existing locale prefix from the path
        $path = preg_replace('#^/(' . implode('|', $supported) . ')(/|$)#', '/', $path);
        $path = $path === '' ? '/' : $path;

        if ($locale === $default) {
            return redirect($path);
        }

        return redirect('/' . $locale . ($path === '/' ? '' : $path));
    }
}
