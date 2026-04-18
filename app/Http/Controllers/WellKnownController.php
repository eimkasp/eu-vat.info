<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class WellKnownController extends Controller
{
    /**
     * RFC 9727 — API Catalog (application/linkset+json per RFC 9264).
     */
    public function apiCatalog(): JsonResponse
    {
        $baseUrl = config('app.url');

        $linkset = [
            'linkset' => [
                [
                    'anchor'       => $baseUrl . '/api/countries',
                    'service-desc' => [['href' => $baseUrl . '/llms.txt', 'type' => 'text/plain']],
                    'service-doc'  => [['href' => $baseUrl . '/llms.txt', 'type' => 'text/plain']],
                    'status'       => [['href' => $baseUrl . '/up']],
                ],
                [
                    'anchor'       => $baseUrl . '/api/vat/validation',
                    'service-desc' => [['href' => $baseUrl . '/llms.txt', 'type' => 'text/plain']],
                    'service-doc'  => [['href' => $baseUrl . '/vat-validation-api', 'type' => 'text/html']],
                    'status'       => [['href' => $baseUrl . '/api/vat/validation/health']],
                ],
                [
                    'anchor'       => $baseUrl . '/api/llm/vat-rates',
                    'service-desc' => [['href' => $baseUrl . '/llms.txt', 'type' => 'text/plain']],
                    'service-doc'  => [['href' => $baseUrl . '/llms.txt', 'type' => 'text/plain']],
                    'status'       => [['href' => $baseUrl . '/up']],
                ],
            ],
        ];

        return response()->json($linkset)
            ->header('Content-Type', 'application/linkset+json');
    }

    /**
     * RFC 8414 — OAuth 2.0 Authorization Server Metadata.
     * All endpoints are public; grant_types_supported: [] signals no OAuth flow is needed.
     */
    public function oauthAuthorizationServer(): JsonResponse
    {
        $baseUrl = config('app.url');

        return response()->json([
            'issuer'                                => $baseUrl,
            'grant_types_supported'                 => [],
            'response_types_supported'              => [],
            'token_endpoint_auth_methods_supported' => ['none'],
            'jwks_uri'                              => $baseUrl . '/.well-known/jwks.json',
            'service_documentation'                 => $baseUrl . '/llms.txt',
            'ui_locales_supported'                  => ['en'],
            'op_policy_uri'                         => $baseUrl . '/privacy-policy',
            'op_tos_uri'                            => $baseUrl . '/terms',
        ]);
    }

    /**
     * RFC 7517 — JSON Web Key Set.
     * Returns bot auth public key if generated, otherwise empty set.
     */
    public function jwks(): JsonResponse
    {
        $jwks = $this->loadBotAuthJwks();

        return response()->json($jwks);
    }

    /**
     * Web Bot Auth — HTTP Message Signatures Directory.
     * IETF WebBotAuth WG: https://datatracker.ietf.org/wg/webbotauth/about/
     *
     * Publishes a JWKS so receiving sites can verify signed requests from this bot/agent.
     */
    public function httpMessageSignaturesDirectory(): JsonResponse
    {
        $jwks = $this->loadBotAuthJwks();

        return response()->json($jwks)
            ->header('Cache-Control', 'public, max-age=86400');
    }

    /**
     * Load the bot auth JWKS from storage.
     */
    private function loadBotAuthJwks(): array
    {
        if (Storage::disk('local')->exists('bot-auth/public-key.json')) {
            return json_decode(Storage::disk('local')->get('bot-auth/public-key.json'), true) ?? ['keys' => []];
        }

        return ['keys' => []];
    }

    /**
     * Agent skills discovery index — lists all available skills with metadata.
     */
    public function agentSkillsIndex(): JsonResponse
    {
        $baseUrl = config('app.url');

        return response()->json([
            'schema_version' => '1.0',
            'name'           => 'EU VAT Info',
            'description'    => 'Free, daily-updated EU VAT rates, calculators, VIES validation, and MCP server for all 27 EU member states.',
            'url'            => $baseUrl,
            'skills'         => [
                [
                    'id'          => 'vat-rates',
                    'name'        => 'EU VAT Rates',
                    'description' => 'Query live EU VAT rates (standard, reduced, super-reduced, parking) for all 27 EU countries. Calculate VAT and compare rates.',
                    'skill_url'   => $baseUrl . '/.well-known/agent-skills/vat-rates/SKILL.md',
                    'mcp_endpoint' => $baseUrl . '/api/mcp',
                    'api_endpoints' => [
                        $baseUrl . '/api/countries',
                        $baseUrl . '/api/countries/{slug}',
                        $baseUrl . '/api/llm/vat-rates',
                    ],
                    'auth' => 'none',
                    'tags' => ['vat', 'tax', 'eu', 'rates', 'calculator'],
                ],
                [
                    'id'          => 'vies-validation',
                    'name'        => 'VIES VAT Number Validation',
                    'description' => 'Validate EU VAT numbers against the official VIES database. Single and batch validation with company name and address lookup.',
                    'skill_url'   => $baseUrl . '/.well-known/agent-skills/vies-validation/SKILL.md',
                    'mcp_endpoint' => $baseUrl . '/api/mcp',
                    'api_endpoints' => [
                        $baseUrl . '/api/vat/validation/validate',
                        $baseUrl . '/api/vat/validation/batch',
                        $baseUrl . '/api/vat/validation/health',
                    ],
                    'auth' => 'none',
                    'tags' => ['vat', 'vies', 'validation', 'eu', 'company'],
                ],
            ],
            'mcp_server' => [
                'endpoint' => $baseUrl . '/api/mcp',
                'transport' => 'http-json-rpc',
                'server_card' => $baseUrl . '/.well-known/mcp/server-card.json',
                'auth' => 'none',
            ],
            'llms_txt'    => $baseUrl . '/llms.txt',
            'agents_md'   => $baseUrl . '/agents.md',
            'api_catalog' => $baseUrl . '/.well-known/api-catalog',
        ]);
    }

    /**
     * Agent skill files served as text/markdown for AI agent discovery.
     * Files live in public/.well-known/agent-skills/{skill}/SKILL.md
     */
    public function agentSkill(string $skill): Response
    {
        $allowed = ['vat-rates', 'vies-validation'];

        if (! in_array($skill, $allowed, true)) {
            abort(404);
        }

        $path = public_path(".well-known/agent-skills/{$skill}/SKILL.md");

        if (! file_exists($path)) {
            abort(404);
        }

        return response(file_get_contents($path))
            ->header('Content-Type', 'text/plain; charset=utf-8');
    }

    /**
     * RFC 9728 — OAuth Protected Resource Metadata.
     * Declares this site as a public resource requiring no authentication.
     * Includes MCP server metadata for AI agent discovery.
     */
    public function oauthProtectedResource(): JsonResponse
    {
        $baseUrl = config('app.url');

        return response()->json([
            'resource'                 => $baseUrl,
            'authorization_servers'    => [$baseUrl],
            'scopes_supported'         => [],
            'bearer_methods_supported' => [],
            'resource_signing_alg_values_supported' => ['ES256'],
            'resource_documentation'   => $baseUrl . '/llms.txt',
            'resource_policy_uri'      => $baseUrl . '/privacy-policy',
            'jwks_uri'                 => $baseUrl . '/.well-known/jwks.json',

            // Agent skill discovery — Markdown files describing how to use each capability
            'agent_skills' => [
                $baseUrl . '/.well-known/agent-skills/vat-rates/SKILL.md',
                $baseUrl . '/.well-known/agent-skills/vies-validation/SKILL.md',
            ],

            // MCP (Model Context Protocol) server — freely accessible, no auth required
            'mcp' => [
                'endpoint'         => $baseUrl . '/api/mcp',
                'transport'        => 'http-json-rpc',
                'protocol_version' => '2024-11-05',
                'server_name'      => 'eu-vat-info',
                'server_version'   => '1.0.0',
                'description'      => 'Free read-only MCP server providing live EU VAT rates, VAT calculations, country comparisons, and VIES VAT number validation for all 27 EU member states.',
                'documentation'    => $baseUrl . '/mcp-server',
                'tools' => [
                    'get_all_vat_rates',
                    'get_country_vat_rate',
                    'calculate_vat',
                    'compare_vat_rates',
                    'validate_vat_number',
                ],
                'clients' => ['VS Code Copilot', 'Cursor', 'Claude Desktop', 'any MCP-compatible client'],
            ],
        ]);
    }

    /**
     * SEP-1649 — MCP Server Card for agent discovery.
     * https://github.com/modelcontextprotocol/modelcontextprotocol/pull/2127
     */
    public function mcpServerCard(): JsonResponse
    {
        $baseUrl = config('app.url');

        return response()->json([
            'serverInfo' => [
                'name'    => 'eu-vat-info',
                'version' => '1.0.0',
            ],
            'transport' => [
                'type'     => 'http',
                'endpoint' => $baseUrl . '/api/mcp',
            ],
            'capabilities' => [
                'tools' => [
                    'listChanged' => false,
                ],
            ],
            'tools' => [
                ['name' => 'get_all_vat_rates',    'description' => 'Get current VAT rates for all 27 EU member states.'],
                ['name' => 'get_country_vat_rate',  'description' => 'Get VAT rates for a specific EU country by name, ISO code, or slug.'],
                ['name' => 'calculate_vat',         'description' => 'Calculate VAT for a given amount and country (add or remove VAT).'],
                ['name' => 'compare_vat_rates',     'description' => 'Compare VAT rates between two or more EU countries.'],
                ['name' => 'validate_vat_number',   'description' => 'Validate an EU VAT number against the official VIES database.'],
            ],
            'authentication' => null,
            'documentation'  => $baseUrl . '/mcp-server',
        ]);
    }
}
