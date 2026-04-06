<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Services\ViesValidationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class McpController extends Controller
{
    private const PROTOCOL_VERSION = '2024-11-05';
    private const SERVER_NAME = 'eu-vat-info';
    private const SERVER_VERSION = '1.0.0';

    public function __construct(
        private ViesValidationService $viesService
    ) {
    }

    public function handle(Request $request): JsonResponse
    {
        $body = $request->json()->all();

        // Validate JSON-RPC structure
        if (! isset($body['jsonrpc']) || $body['jsonrpc'] !== '2.0' || ! isset($body['method'])) {
            return $this->errorResponse(null, -32600, 'Invalid JSON-RPC request');
        }

        $id = $body['id'] ?? null;
        $method = $body['method'];
        $params = $body['params'] ?? [];

        return match ($method) {
            'initialize' => $this->initialize($id),
            'notifications/initialized' => response()->json(null, 204),
            'tools/list' => $this->toolsList($id),
            'tools/call' => $this->toolsCall($id, $params),
            'ping' => $this->successResponse($id, []),
            default => $this->errorResponse($id, -32601, "Method not found: {$method}"),
        };
    }

    private function initialize(mixed $id): JsonResponse
    {
        return $this->successResponse($id, [
            'protocolVersion' => self::PROTOCOL_VERSION,
            'capabilities' => [
                'tools' => [
                    'listChanged' => false,
                ],
            ],
            'serverInfo' => [
                'name' => self::SERVER_NAME,
                'version' => self::SERVER_VERSION,
            ],
        ]);
    }

    private function toolsList(mixed $id): JsonResponse
    {
        return $this->successResponse($id, [
            'tools' => [
                [
                    'name' => 'get_all_vat_rates',
                    'description' => 'Get current VAT rates for all EU member states. Returns standard, reduced, super-reduced, and parking rates for each country.',
                    'inputSchema' => [
                        'type' => 'object',
                        'properties' => new \stdClass(),
                    ],
                ],
                [
                    'name' => 'get_country_vat_rate',
                    'description' => 'Get VAT rate details for a specific EU country by name, ISO code, or slug.',
                    'inputSchema' => [
                        'type' => 'object',
                        'properties' => [
                            'country' => [
                                'type' => 'string',
                                'description' => 'Country name (e.g. "Germany"), ISO code (e.g. "DE"), or slug (e.g. "germany")',
                            ],
                        ],
                        'required' => ['country'],
                    ],
                ],
                [
                    'name' => 'calculate_vat',
                    'description' => 'Calculate VAT for a given amount and country. Can add VAT to a net amount or extract VAT from a gross amount.',
                    'inputSchema' => [
                        'type' => 'object',
                        'properties' => [
                            'amount' => [
                                'type' => 'number',
                                'description' => 'The monetary amount to calculate VAT for',
                            ],
                            'country' => [
                                'type' => 'string',
                                'description' => 'Country name, ISO code, or slug',
                            ],
                            'mode' => [
                                'type' => 'string',
                                'enum' => ['add', 'remove'],
                                'description' => '"add" to add VAT to a net amount, "remove" to extract VAT from a gross amount. Default: "add"',
                            ],
                            'rate_type' => [
                                'type' => 'string',
                                'enum' => ['standard', 'reduced', 'super_reduced', 'parking'],
                                'description' => 'Which VAT rate to use. Default: "standard"',
                            ],
                        ],
                        'required' => ['amount', 'country'],
                    ],
                ],
                [
                    'name' => 'compare_vat_rates',
                    'description' => 'Compare VAT rates between two or more EU countries.',
                    'inputSchema' => [
                        'type' => 'object',
                        'properties' => [
                            'countries' => [
                                'type' => 'array',
                                'items' => ['type' => 'string'],
                                'description' => 'Array of country names, ISO codes, or slugs to compare',
                            ],
                        ],
                        'required' => ['countries'],
                    ],
                ],
                [
                    'name' => 'validate_vat_number',
                    'description' => 'Validate an EU VAT number against the official VIES (VAT Information Exchange System) database. Returns the registration status and, for valid numbers, the company name and address.',
                    'inputSchema' => [
                        'type' => 'object',
                        'properties' => [
                            'country_code' => [
                                'type' => 'string',
                                'description' => 'Two-letter ISO country code (e.g. "DE", "LT", "FR"). Greece uses "EL".',
                            ],
                            'vat_number' => [
                                'type' => 'string',
                                'description' => 'VAT number without the country code prefix (e.g. "123456789" for DE123456789)',
                            ],
                        ],
                        'required' => ['country_code', 'vat_number'],
                    ],
                ],
                        ],
                        'required' => ['countries'],
                    ],
                ],
            ],
        ]);
    }

    private function toolsCall(mixed $id, array $params): JsonResponse
    {
        $toolName = $params['name'] ?? '';
        $arguments = $params['arguments'] ?? [];

        return match ($toolName) {
            'get_all_vat_rates' => $this->getAllVatRates($id),
            'get_country_vat_rate' => $this->getCountryVatRate($id, $arguments),
            'calculate_vat' => $this->calculateVat($id, $arguments),
            'compare_vat_rates' => $this->compareVatRates($id, $arguments),
            'validate_vat_number' => $this->validateVatNumber($id, $arguments),
            default => $this->errorResponse($id, -32602, "Unknown tool: {$toolName}"),
        };
    }

    private function getAllVatRates(mixed $id): JsonResponse
    {
        $countries = Cache::remember('mcp_all_vat_rates', 600, function () {
            return Country::orderBy('name')->get()->map(fn ($c) => [
                'country' => $c->name,
                'iso_code' => $c->iso_code,
                'slug' => $c->slug,
                'currency' => $c->currency_display,
                'rates' => [
                    'standard' => $c->standard_rate,
                    'reduced' => $c->reduced_rate,
                    'super_reduced' => $c->super_reduced_rate,
                    'parking' => $c->parking_rate,
                ],
                'last_updated' => $c->updated_at?->toIso8601String(),
            ])->toArray();
        });

        return $this->toolResult($id, json_encode($countries, JSON_PRETTY_PRINT));
    }

    private function getCountryVatRate(mixed $id, array $args): JsonResponse
    {
        $query = $args['country'] ?? '';
        if (empty($query)) {
            return $this->toolResult($id, 'Error: "country" parameter is required.', true);
        }

        $country = $this->findCountry($query);
        if (! $country) {
            return $this->toolResult($id, "Error: Country not found for \"{$query}\". Try using the full country name, ISO code (e.g. DE), or slug (e.g. germany).", true);
        }

        $data = [
            'country' => $country->name,
            'iso_code' => $country->iso_code,
            'slug' => $country->slug,
            'currency' => $country->currency_display,
            'rates' => [
                'standard' => $country->standard_rate,
                'reduced' => $country->reduced_rate,
                'super_reduced' => $country->super_reduced_rate,
                'parking' => $country->parking_rate,
            ],
            'last_updated' => $country->updated_at?->toIso8601String(),
        ];

        return $this->toolResult($id, json_encode($data, JSON_PRETTY_PRINT));
    }

    private function calculateVat(mixed $id, array $args): JsonResponse
    {
        $amount = $args['amount'] ?? null;
        $countryQuery = $args['country'] ?? '';
        $mode = $args['mode'] ?? 'add';
        $rateType = $args['rate_type'] ?? 'standard';

        if ($amount === null || ! is_numeric($amount)) {
            return $this->toolResult($id, 'Error: "amount" must be a valid number.', true);
        }
        if (empty($countryQuery)) {
            return $this->toolResult($id, 'Error: "country" parameter is required.', true);
        }

        $country = $this->findCountry($countryQuery);
        if (! $country) {
            return $this->toolResult($id, "Error: Country not found for \"{$countryQuery}\".", true);
        }

        $rate = match ($rateType) {
            'reduced' => $country->reduced_rate,
            'super_reduced' => $country->super_reduced_rate,
            'parking' => $country->parking_rate,
            default => $country->standard_rate,
        };

        if ($rate === null) {
            return $this->toolResult($id, "Error: {$country->name} does not have a {$rateType} rate.", true);
        }

        $amount = (float) $amount;
        if ($mode === 'remove') {
            $net = round($amount / (1 + $rate / 100), 2);
            $vat = round($amount - $net, 2);
            $gross = $amount;
        } else {
            $net = $amount;
            $vat = round($amount * $rate / 100, 2);
            $gross = round($amount + $vat, 2);
        }

        $data = [
            'country' => $country->name,
            'rate_type' => $rateType,
            'rate_percent' => $rate,
            'mode' => $mode,
            'currency' => $country->currency_display,
            'net_amount' => $net,
            'vat_amount' => $vat,
            'gross_amount' => $gross,
        ];

        return $this->toolResult($id, json_encode($data, JSON_PRETTY_PRINT));
    }

    private function validateVatNumber(mixed $id, array $args): JsonResponse
    {
        $countryCode = strtoupper(trim($args['country_code'] ?? ''));
        $vatNumber = trim($args['vat_number'] ?? '');

        if (! $countryCode || strlen($countryCode) !== 2) {
            return $this->toolResult($id, 'Error: "country_code" must be a 2-letter ISO country code (e.g. "DE", "LT").', true);
        }
        if (! $vatNumber || strlen($vatNumber) < 3) {
            return $this->toolResult($id, 'Error: "vat_number" is required (without the country prefix).', true);
        }

        try {
            $result = $this->viesService->validate($countryCode, $vatNumber);

            $data = [
                'valid' => $result['valid'] ?? false,
                'country_code' => $result['country_code'] ?? $countryCode,
                'vat_number' => $result['vat_number'] ?? $vatNumber,
                'name' => $result['name'] ?? null,
                'address' => $result['address'] ?? null,
                'source' => $result['source'] ?? 'vies',
                'checked_at' => now()->toIso8601String(),
            ];

            return $this->toolResult($id, json_encode($data, JSON_PRETTY_PRINT));
        } catch (\Exception $e) {
            return $this->toolResult($id, 'Error: VIES validation service unavailable. Please try again later.', true);
        }
    }

    private function compareVatRates(mixed $id, array $args): JsonResponse
    {
        $queries = $args['countries'] ?? [];        if (count($queries) < 2) {
            return $this->toolResult($id, 'Error: Please provide at least 2 countries to compare.', true);
        }

        $results = [];
        foreach (array_slice($queries, 0, 10) as $query) {
            $country = $this->findCountry($query);
            if ($country) {
                $results[] = [
                    'country' => $country->name,
                    'iso_code' => $country->iso_code,
                    'standard_rate' => $country->standard_rate,
                    'reduced_rate' => $country->reduced_rate,
                    'super_reduced_rate' => $country->super_reduced_rate,
                    'parking_rate' => $country->parking_rate,
                ];
            } else {
                $results[] = ['query' => $query, 'error' => 'Country not found'];
            }
        }

        return $this->toolResult($id, json_encode($results, JSON_PRETTY_PRINT));
    }

    private function findCountry(string $query): ?Country
    {
        $q = trim($query);

        return Country::where('iso_code', strtoupper($q))
            ->orWhere('slug', strtolower($q))
            ->orWhereRaw('LOWER(name) = ?', [strtolower($q)])
            ->first();
    }

    private function toolResult(mixed $id, string $text, bool $isError = false): JsonResponse
    {
        return $this->successResponse($id, [
            'content' => [
                ['type' => 'text', 'text' => $text],
            ],
            'isError' => $isError,
        ]);
    }

    private function successResponse(mixed $id, array $result): JsonResponse
    {
        return response()->json([
            'jsonrpc' => '2.0',
            'id' => $id,
            'result' => $result,
        ]);
    }

    private function errorResponse(mixed $id, int $code, string $message): JsonResponse
    {
        return response()->json([
            'jsonrpc' => '2.0',
            'id' => $id,
            'error' => [
                'code' => $code,
                'message' => $message,
            ],
        ]);
    }
}
