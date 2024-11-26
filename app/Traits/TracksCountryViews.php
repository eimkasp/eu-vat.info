<?php

namespace App\Traits;

use App\Services\CountryAnalyticsService;

trait TracksCountryViews
{
    protected function trackCountryView($country, $type = 'view', $metadata = [])
    {
        if (!$country) return;

        $analyticsService = app(CountryAnalyticsService::class);
        $analyticsService->trackView($country, request(), $type, $metadata);
    }
}
