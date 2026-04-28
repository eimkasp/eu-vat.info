<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    /**
     * 301 redirect: /country/{slug}[/{tab}] → /vat-calculator/{slug}
     */
    public function country(string $slug): RedirectResponse
    {
        return redirect(locale_path('/vat-calculator/' . $slug), 301);
    }

    /**
     * 301 redirect: /vat-calculator/{iso_code} → /vat-calculator/{slug}
     * Handles 2-letter ISO codes (e.g. /vat-calculator/mt → /vat-calculator/malta).
     * Falls back to /vat-calculator if the code doesn't match any country (e.g. locale codes).
     */
    public function isoCode(string $code): RedirectResponse
    {
        $country = Country::where('iso_code', strtoupper($code))
            ->orWhere('iso_code_2', strtoupper($code))
            ->first();

        if ($country) {
            return redirect(locale_path('/vat-calculator/' . $country->slug), 301);
        }

        return redirect(locale_path('/vat-calculator'), 301);
    }

    /**
     * Legacy redirect: /calculation?country=X&amount=Y&rate=Z&mode=M
     *   → /vat-calculation/X/Y/Z/M
     */
    public function legacyCalculation(Request $request): RedirectResponse
    {
        $country = $request->query('country', '');
        $amount  = $request->query('amount', '100');
        $rate    = $request->query('rate', '0');
        $mode    = $request->query('mode', 'exclude');

        if (! $country) {
            abort(404);
        }

        return redirect(locale_path("/vat-calculation/{$country}/{$amount}/{$rate}/{$mode}"), 301);
    }
}
