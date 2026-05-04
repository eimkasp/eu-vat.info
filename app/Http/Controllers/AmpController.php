<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Support\Facades\Cache;

class AmpController extends Controller
{
    public function home()
    {
        $countries = Cache::remember('all_eu_countries_amp', 3600, function () {
            return Country::where('is_eu_member', true)
                ->orderBy('name', 'ASC')
                ->get();
        });

        return response()
            ->view('amp.home', compact('countries'))
            ->header('Content-Type', 'text/html; charset=utf-8');
    }

    public function vatRates()
    {
        $countries = Cache::remember('all_eu_countries_amp', 3600, function () {
            return Country::where('is_eu_member', true)
                ->orderBy('name', 'ASC')
                ->get();
        });

        return response()
            ->view('amp.vat-rates', compact('countries'))
            ->header('Content-Type', 'text/html; charset=utf-8');
    }

    public function country(string $slug)
    {
        $country = Country::where('slug', $slug)->firstOrFail();
        $vatRates = $country->vatRates()->orderBy('effective_from', 'desc')->get();

        return response()
            ->view('amp.country', compact('country', 'vatRates'))
            ->header('Content-Type', 'text/html; charset=utf-8');
    }
}
