<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class LlmsController extends Controller
{
    /**
     * Serve /llms-full.txt — a Markdown table of all EU VAT rates,
     * cached for 24 hours and optimised for LLM context injection.
     */
    public function fullTxt(): Response
    {
        $content = Cache::remember('llms_full_txt', 86400, function () {
            $countries = Country::orderBy('name')->get();
            $text      = "# Full EU VAT Rates List\n\n";
            $text     .= "| Country | ISO | Standard | Reduced | Super Reduced | Parking |\n";
            $text     .= "|---|---|---|---|---|---|\n";

            foreach ($countries as $c) {
                $text .= '| ' . $c->name . ' | ' . $c->iso_code . ' | ' . $c->standard_rate . '% | '
                    . ($c->reduced_rate       ? $c->reduced_rate . '%'       : '-') . ' | '
                    . ($c->super_reduced_rate ? $c->super_reduced_rate . '%' : '-') . ' | '
                    . ($c->parking_rate       ? $c->parking_rate . '%'       : '-') . " |\n";
            }

            return $text;
        });

        return response($content)->header('Content-Type', 'text/plain');
    }
}
