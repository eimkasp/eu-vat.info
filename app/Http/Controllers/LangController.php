<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LangController extends Controller
{
    /**
     * Switch the active locale and redirect back to the equivalent page on this site.
     */
    public function switch(Request $request, string $locale): RedirectResponse
    {
        $supported = array_keys(config('translation.supported_languages', []));

        abort_unless(in_array($locale, $supported, true), 404);

        $previous = parse_url(url()->previous()) ?: [];
        $sameHost = strcasecmp($previous['host'] ?? $request->getHost(), $request->getHost()) === 0;
        $path = $sameHost ? '/'.ltrim($previous['path'] ?? '/', '/') : '/';
        $path = preg_replace('#^/('.implode('|', array_map('preg_quote', $supported)).')(?=/|$)#', '', $path) ?: '/';

        if ($locale === config('translation.default_language', 'en')) {
            return redirect($path);
        }

        return redirect('/'.$locale.($path === '/' ? '' : $path));
    }
}
