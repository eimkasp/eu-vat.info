<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VatDatasetDownloadController extends Controller
{
    public function json(): JsonResponse
    {
        $countries = Country::query()
            ->where('is_eu_member', true)
            ->orderBy('name')
            ->get()
            ->map(fn (Country $country) => [
                'name' => $country->name,
                'slug' => $country->slug,
                'iso_code' => $country->iso_code,
                'standard_rate' => $country->standard_rate,
                'reduced_rate' => $country->primaryReducedRate(),
                'reduced_rates' => $country->reducedRates(),
                'super_reduced_rate' => $country->super_reduced_rate,
                'parking_rate' => $country->parking_rate,
                'currency_code' => $country->currencyCode(),
                'last_updated' => $country->updated_at?->toIso8601String(),
            ]);

        return response()->json(['data' => $countries])
            ->header('Cache-Control', 'public, max-age=3600');
    }

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
                'reduced_rates',
            ]);

            Country::query()
                ->where('is_eu_member', true)
                ->orderBy('name')
                ->each(function (Country $country) use ($output) {
                    fputcsv($output, [
                        $country->name,
                        $country->iso_code,
                        $country->standard_rate,
                        $country->primaryReducedRate(),
                        $country->super_reduced_rate,
                        $country->parking_rate,
                        $country->currencyCode(),
                        $country->updated_at?->toIso8601String(),
                        implode(';', array_map(fn (float $rate) => Country::formatRate($rate), $country->reducedRates())),
                    ]);
                });

            fclose($output);
        }, 'eu-vat-rates.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
