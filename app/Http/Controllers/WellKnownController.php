<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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
     * Empty key set; no token signing (public API).
     */
    public function jwks(): JsonResponse
    {
        return response()->json(['keys' => []]);
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
            'authorization_servers'    => [$baseUrl . '/.well-known/oauth-authorization-server'],
            'scopes_supported'         => [],
            'bearer_methods_supported' => [],
            'resource_documentation'   => $baseUrl . '/llms.txt',
            'resource_policy_uri'      => $baseUrl . '/privacy-policy',

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
}
