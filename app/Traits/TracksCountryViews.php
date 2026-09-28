<?php

namespace App\Traits;

use App\Models\Country;
use App\Services\CountryAnalyticsService;

trait TracksCountryViews
{
    protected function trackCountryView(?Country $country, string $type = 'view', array $metadata = []): void
    {
        if (! $country) {
            return;
        }

        $recent = array_values(array_unique([$country->id, ...(array) session('recent_countries', [])]));
        session()->put('recent_countries', array_slice($recent, 0, 6));

        app(CountryAnalyticsService::class)->trackView($country, request(), $type, $metadata);
    }
}
