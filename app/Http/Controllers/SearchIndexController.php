<?php

namespace App\Http\Controllers;

use App\Support\SiteNavigation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SearchIndexController extends Controller
{
    /**
     * Items for the ⌘K command palette, fetched lazily so they are not repeated in every page's HTML.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $locale = (string) $request->query('locale', config('translation.default_language', 'en'));

        if (array_key_exists($locale, config('translation.supported_languages', []))) {
            App::setLocale($locale);
        }

        return response()
            ->json(SiteNavigation::paletteItems())
            ->header('Cache-Control', 'public, max-age=600');
    }
}
