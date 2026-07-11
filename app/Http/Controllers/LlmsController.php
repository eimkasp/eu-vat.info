<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Services\Seo\VatCategorySeoService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class LlmsController extends Controller
{
    public function index(VatCategorySeoService $vatCategories): Response
    {
        $baseUrl = rtrim(config('seo.canonical_url', 'https://vat.businesspress.io'), '/');
        $countries = Country::query()
            ->where('is_eu_member', true)
            ->withExists(['vatRates', 'vatRateChanges'])
            ->orderBy('name')
            ->get();

        $text = "# EU VAT Info\n\n";
        $text .= "Canonical website: {$baseUrl}\n\n";
        $text .= "EU VAT Info provides current and historical VAT rates, calculators, VIES validation, source-backed rate changes, and machine-readable data for the 27 EU member states.\n\n";
        $text .= "## Core resources\n\n";
        $text .= "- [EU VAT calculator]({$baseUrl}/vat-calculator)\n";
        $text .= "- [VAT number validator]({$baseUrl}/vat-number-validator)\n";
        $text .= "- [VAT rate changes]({$baseUrl}/vat-changes)\n";
        $text .= "- [EU VAT dataset]({$baseUrl}/datasets/eu-vat-rates)\n";
        $text .= "- [JSON API]({$baseUrl}/api/countries)\n";
        $text .= "- [Full Markdown rates]({$baseUrl}/llms-full.txt)\n\n";
        $text .= "## Country resources\n\n";

        foreach ($countries as $country) {
            $links = "[calculator]({$baseUrl}/vat-calculator/{$country->slug}) · [validator]({$baseUrl}/vat-number-validator/{$country->slug})";

            if ($country->hasVatHistory()) {
                $links .= " · [history]({$baseUrl}/vat-rates/{$country->slug}/history)";
            }

            $text .= "- {$country->name}: {$links}\n";
        }

        $categories = $vatCategories->eligibleCategories();
        if ($categories->isNotEmpty()) {
            $text .= "\n## VAT categories\n\n";
            $text .= "- [All verified VAT categories]({$baseUrl}/vat-rates/categories)\n";

            foreach ($categories as $category) {
                $text .= "- [{$category['name']} VAT rates]({$baseUrl}/vat-rates/categories/{$category['slug']}) — {$category['country_count']} EU countries\n";
            }
        }

        return response($text)->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    /**
     * Serve /llms-full.txt — a Markdown table of all EU VAT rates,
     * cached for 24 hours and optimised for LLM context injection.
     */
    public function fullTxt(): Response
    {
        $content = Cache::remember('llms_full_txt', 86400, function () {
            $countries = Country::where('is_eu_member', true)->orderBy('name')->get();
            $text = "# Full EU VAT Rates List\n\n";
            $text .= "| Country | ISO | Standard | Reduced | Super Reduced | Parking |\n";
            $text .= "|---|---|---|---|---|---|\n";

            foreach ($countries as $c) {
                $text .= '| '.$c->name.' | '.$c->iso_code.' | '.$c->standard_rate.'% | '
                    .($c->reduced_rate ? $c->reduced_rate.'%' : '-').' | '
                    .($c->super_reduced_rate ? $c->super_reduced_rate.'%' : '-').' | '
                    .($c->parking_rate ? $c->parking_rate.'%' : '-')." |\n";
            }

            return $text;
        });

        return response($content)->header('Content-Type', 'text/plain');
    }
}
