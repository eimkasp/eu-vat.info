<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use App\Models\VatRateChange;
use Illuminate\Support\Facades\Cache;

class X402Controller extends Controller
{
    /**
     * Donate endpoint — returns a thank-you message upon successful x402 payment.
     */
    public function donate()
    {
        return response()->json([
            'message' => 'Thank you for your donation! 🙏',
            'project' => 'EU VAT Info',
            'description' => 'Your donation helps maintain this free, open-source EU VAT data platform serving developers, businesses, and AI agents across the European Union.',
            'url' => config('app.url'),
            'impact' => [
                'countries_covered' => 27,
                'languages_supported' => 24,
                'data_sources' => 'European Commission, national tax authorities',
                'update_frequency' => 'Daily',
            ],
        ]);
    }

    /**
     * Premium VAT rates — enriched data with change history and metadata.
     */
    public function premiumVatRates()
    {
        $data = Cache::remember('x402_premium_vat_rates', 300, function () {
            $countries = Country::orderBy('name')->get();
            $recentChanges = VatRateChange::with('country:id,name,code,slug')
                ->orderByDesc('change_date')
                ->limit(50)
                ->get();

            return [
                'meta' => [
                    'total_countries' => $countries->count(),
                    'last_updated' => $countries->max('updated_at')?->toIso8601String(),
                    'source' => 'European Commission & national tax authorities',
                    'update_frequency' => 'Daily automated sync',
                ],
                'countries' => $countries->map(fn (Country $c) => [
                    'name' => $c->name,
                    'iso_code' => $c->iso_code,
                    'code' => $c->code,
                    'slug' => $c->slug,
                    'currency' => $c->currency,
                    'rates' => [
                        'standard' => $c->standard_rate,
                        'reduced' => $c->reduced_rate,
                        'second_reduced' => $c->second_reduced_rate,
                        'super_reduced' => $c->super_reduced_rate,
                        'parking' => $c->parking_rate,
                    ],
                    'eu_member_since' => $c->eu_member_since,
                    'updated_at' => $c->updated_at?->toIso8601String(),
                ])->values(),
                'recent_changes' => $recentChanges->map(fn ($change) => [
                    'country' => $change->country?->name,
                    'country_code' => $change->country?->code,
                    'rate_type' => $change->rate_type,
                    'old_rate' => (float) $change->old_rate,
                    'new_rate' => (float) $change->new_rate,
                    'change_date' => $change->change_date?->toDateString(),
                    'direction' => $change->change_direction,
                    'reason' => $change->change_reason,
                ])->values(),
            ];
        });

        return response()->json($data);
    }

    /**
     * Premium country data — full detail with compliance context.
     */
    public function premiumCountry(string $slug)
    {
        $data = Cache::remember("x402_premium_country_{$slug}", 300, function () use ($slug) {
            $country = Country::where('slug', $slug)->firstOrFail();
            $changes = VatRateChange::where('country_id', $country->id)
                ->orderByDesc('change_date')
                ->get();

            return [
                'country' => [
                    'name' => $country->name,
                    'iso_code' => $country->iso_code,
                    'code' => $country->code,
                    'slug' => $country->slug,
                    'currency' => $country->currency,
                    'eu_member_since' => $country->eu_member_since,
                    'capital' => $country->capital,
                    'population' => $country->population,
                ],
                'rates' => [
                    'standard' => $country->standard_rate,
                    'reduced' => $country->reduced_rate,
                    'second_reduced' => $country->second_reduced_rate,
                    'super_reduced' => $country->super_reduced_rate,
                    'parking' => $country->parking_rate,
                ],
                'rate_history' => $changes->map(fn ($change) => [
                    'rate_type' => $change->rate_type,
                    'old_rate' => (float) $change->old_rate,
                    'new_rate' => (float) $change->new_rate,
                    'change_date' => $change->change_date?->toDateString(),
                    'direction' => $change->change_direction,
                    'reason' => $change->change_reason,
                    'description' => $change->description,
                ])->values(),
                'meta' => [
                    'updated_at' => $country->updated_at?->toIso8601String(),
                    'source' => 'European Commission',
                    'api_url' => config('app.url') . "/api/countries/{$slug}",
                    'web_url' => config('app.url') . "/country/{$slug}",
                ],
            ];
        });

        return response()->json($data);
    }

    /**
     * x402 payment info — describes available paid endpoints (no payment required).
     */
    public function info()
    {
        $routes = config('x402.routes', []);
        $enabled = config('x402.enabled', false);
        $baseUrl = rtrim(config('app.url'), '/');

        return response()->json([
            'protocol' => 'x402',
            'version' => 2,
            'enabled' => $enabled,
            'docs' => 'https://x402.org',
            'description' => 'EU VAT Info supports the x402 payment protocol for agent-native HTTP payments. AI agents can donate or access premium endpoints by paying with USDC via the x402 protocol.',
            'network' => config('x402.network'),
            'facilitator' => $baseUrl . '/api/x402',
            'payTo' => config('x402.wallet_address'),
            'asset' => 'USDC',
            'donate_page' => $baseUrl . '/donate',
            'endpoints' => collect($routes)->map(fn ($config, $route) => [
                'route' => $route,
                'url' => $baseUrl . '/' . ltrim(explode(' ', $route, 2)[1] ?? '', '/'),
                'price' => $config['price'],
                'description' => $config['description'],
                'mime_type' => $config['mime_type'] ?? 'application/json',
            ])->values(),
            'free_endpoints' => [
                'GET /api' => 'API discovery index (free)',
                'GET /api/x402/info' => 'x402 payment discovery (free, this endpoint)',
                'GET /api/countries' => 'All EU country VAT rates (free)',
                'GET /api/countries/{slug}' => 'Single country VAT data (free)',
                'GET /api/llm/vat-rates' => 'LLM-optimized VAT rates (free)',
                'GET /api/vat-changes' => 'Recent VAT rate changes (free)',
                'POST /api/vat/validation/validate' => 'VIES VAT number validation (free)',
            ],
        ]);
    }

    /**
     * Bazaar-compatible x402 resource discovery — returns protected resources as a JSON array.
     */
    public function discoveryResources()
    {
        $routes = config('x402.routes', []);
        $baseUrl = rtrim(config('app.url'), '/');
        $walletAddress = config('x402.wallet_address');
        $network = config('x402.network');

        $resources = collect($routes)->map(function ($config, $route) use ($baseUrl, $walletAddress, $network) {
            [$method, $path] = explode(' ', $route, 2);

            return [
                'url' => $baseUrl . $path,
                'method' => $method,
                'network' => $network,
                'payTo' => $walletAddress,
                'maxAmountRequired' => $this->priceToAtomic($config['price']),
                'asset' => 'USDC',
                'scheme' => 'exact',
                'description' => $config['description'],
                'mimeType' => $config['mime_type'] ?? 'application/json',
            ];
        })->values();

        return response()->json($resources);
    }

    /**
     * Convert a human-readable price ("$0.10") to USDC atomic units (6 decimals).
     */
    private function priceToAtomic(string $price): string
    {
        $usd = (float) str_replace(['$', ','], '', $price);

        return (string) (int) round($usd * 1_000_000);
    }
}
