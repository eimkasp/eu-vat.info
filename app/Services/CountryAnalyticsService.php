<?php

namespace App\Services;

use App\Models\Country;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class CountryAnalyticsService
{
    public function trackView(Country $country, Request $request, string $type = 'view', array $metadata = []): void
    {
        $location = Location::get($request->ip());
        
        $country->analytics()->create([
            'type' => $type,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referer' => $request->header('referer'),
            'location_country' => $location ? $location->countryName : null,
            'location_city' => $location ? $location->cityName : null,
            'amount' => $metadata['amount'] ?? null,
            'rate_used' => $metadata['rate_used'] ?? null,
            'meta_data' => !empty($metadata) ? $metadata : null,
        ]);
    }
}
