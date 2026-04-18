<?php

return [

    /*
    |--------------------------------------------------------------------------
    | x402 Payment Protocol Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the x402 HTTP payment protocol. This enables AI agents
    | and clients to pay for premium API access via crypto (USDC on Base).
    |
    | Protocol: https://x402.org
    | Docs: https://docs.x402.org
    |
    */

    'enabled' => env('X402_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | Facilitator URL
    |--------------------------------------------------------------------------
    |
    | The facilitator verifies and settles payments on your behalf.
    | Testnet:  https://x402.org/facilitator
    | Mainnet:  https://api.cdp.coinbase.com/platform/v2/x402
    |
    */

    'facilitator_url' => env('X402_FACILITATOR_URL', 'https://x402.org/facilitator'),

    /*
    |--------------------------------------------------------------------------
    | Receiving Wallet Address (EVM)
    |--------------------------------------------------------------------------
    |
    | Your EVM wallet address to receive USDC payments (Base network).
    |
    */

    'wallet_address' => env('X402_WALLET_ADDRESS', ''),

    /*
    |--------------------------------------------------------------------------
    | Network
    |--------------------------------------------------------------------------
    |
    | CAIP-2 network identifier.
    | Base Sepolia (testnet): eip155:84532
    | Base Mainnet:           eip155:8453
    |
    */

    'network' => env('X402_NETWORK', 'eip155:84532'),

    /*
    |--------------------------------------------------------------------------
    | Protected Routes
    |--------------------------------------------------------------------------
    |
    | Routes that require x402 payment. Each route maps to its payment config.
    | Price is in USD (e.g., "$0.01" = 1 cent in USDC).
    |
    */

    'routes' => [
        'GET /api/x402/donate' => [
            'price' => '$0.10',
            'description' => 'Donate $0.10 to support EU VAT Info — a free, open-source EU VAT data platform',
            'mime_type' => 'application/json',
        ],
        'GET /api/x402/premium/vat-rates' => [
            'price' => '$0.01',
            'description' => 'Premium VAT rates data with extended metadata, update timestamps, and rate change history',
            'mime_type' => 'application/json',
        ],
        'GET /api/x402/premium/country/{slug}' => [
            'price' => '$0.005',
            'description' => 'Premium country VAT data with compliance guide, calculator context, and full rate history',
            'mime_type' => 'application/json',
        ],
    ],

];
