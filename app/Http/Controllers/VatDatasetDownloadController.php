<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VatDatasetDownloadController extends Controller
{
    public function csv(): StreamedResponse
    {
        return response()->streamDownload(function () {
            $output = fopen('php://output', 'w');
            fputcsv($output, [
                'country',
                'iso_code',
                'standard_rate',
                'reduced_rate',
                'super_reduced_rate',
                'parking_rate',
                'currency_code',
                'last_updated',
            ]);

            Country::query()
                ->where('is_eu_member', true)
                ->orderBy('name')
                ->each(function (Country $country) use ($output) {
                    fputcsv($output, [
                        $country->name,
                        $country->iso_code,
                        $country->standard_rate,
                        $country->reduced_rate,
                        $country->super_reduced_rate,
                        $country->parking_rate,
                        $country->currency_code,
                        $country->updated_at?->toIso8601String(),
                    ]);
                });

            fclose($output);
        }, 'eu-vat-rates.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
