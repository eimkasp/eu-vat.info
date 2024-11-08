<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use Illuminate\Support\Facades\Cache;

class CountryRatesController extends Controller
{
    public function index()
    {
        $countries = Cache::remember('api_countries', 600, function () {
            return Country::orderBy('name', 'ASC')->get();
        });

        return CountryResource::collection($countries);
    }

    public function show($slug)
    {
        $country = Cache::remember("api_country_{$slug}", 600, function () use ($slug) {
            return Country::where('slug', $slug)->firstOrFail();
        });

        return new CountryResource($country);
    }
}
