<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class EmbedController extends Controller
{
    private const DEFAULT_COUNTRY = 'united-kingdom';

    public function index(?string $country = null)
    {
        $selectedCountry = $country === null
            ? $this->defaultCountry()
            : Country::calculatorAvailable()->where('slug', $country)->first();

        abort_unless($selectedCountry, 404);

        return view('widget.embed', [
            'selectedCountry' => $selectedCountry,
            'countries' => Country::calculatorAvailable()->orderByDesc('is_eu_member')->orderBy('name')->get(['name', 'slug']),
        ]);
    }

    public function iframe(Request $request, ?string $country = null)
    {
        $selectedCountry = ($country ? Country::calculatorAvailable()->where('slug', $country)->first() : null)
            ?? $this->defaultCountry();

        return view('widget.iframe', [
            'country' => $selectedCountry?->slug,
            'style' => $request->query('style') === 'horizontal' ? 'horizontal' : 'vertical',
        ]);
    }

    private function defaultCountry(): ?Country
    {
        return Country::calculatorAvailable()->where('slug', self::DEFAULT_COUNTRY)->first()
            ?? Country::calculatorAvailable()->orderByDesc('is_eu_member')->orderBy('name')->first();
    }
}
