<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * x402 Payment Protocol Middleware
 *
 * Implements the server (seller) side of the x402 protocol:
 * 1. Matches incoming requests against configured paid routes
 * 2. Returns HTTP 402 with PAYMENT-REQUIRED header if no payment provided
 * 3. Verifies payment via facilitator if PAYMENT-SIGNATURE header present
 * 4. Settles payment after serving the response
 *
 * @see https://x402.org
 * @see https://docs.x402.org
 */
class X402PaymentMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! config('x402.enabled')) {
            return $next($request);
        }

        $routeConfig = $this->matchRoute($request);

        if (! $routeConfig) {
            return $next($request);
        }

        $paymentSignature = $request->header('PAYMENT-SIGNATURE');

        if (! $paymentSignature) {
            return $this->returnPaymentRequired($routeConfig);
        }

        // Verify payment via facilitator
        $verification = $this->verifyPayment($paymentSignature, $routeConfig);

        if (! $verification['valid']) {
            return $this->returnPaymentRequired($routeConfig, 'Payment verification failed');
        }

        // Payment verified — serve the resource
        $response = $next($request);

        // Settle payment asynchronously (best effort)
        $this->settlePayment($paymentSignature, $routeConfig);

        // Add PAYMENT-RESPONSE header
        $settlementResponse = base64_encode(json_encode([
            'success' => true,
            'network' => config('x402.network'),
        ]));
        $response->headers->set('PAYMENT-RESPONSE', $settlementResponse);

        return $response;
    }

    /**
     * Match the current request against configured x402 routes.
     */
    protected function matchRoute(Request $request): ?array
    {
        $method = strtoupper($request->method());
        $path = '/' . ltrim($request->path(), '/');
        $routes = config('x402.routes', []);

        foreach ($routes as $routePattern => $routeConfig) {
            [$routeMethod, $routePath] = explode(' ', $routePattern, 2);

            if ($method !== strtoupper($routeMethod)) {
                continue;
            }

            // Convert Laravel-style {param} to regex
            $regex = preg_replace('/\{[^}]+\}/', '[^/]+', $routePath);
            $regex = '#^' . $regex . '$#';

            if (preg_match($regex, $path)) {
                return array_merge($routeConfig, ['route' => $routePattern]);
            }
        }

        return null;
    }

    /**
     * Return HTTP 402 Payment Required with x402 protocol headers.
     */
    protected function returnPaymentRequired(array $routeConfig, ?string $error = null): Response
    {
        $walletAddress = config('x402.wallet_address');
        $network = config('x402.network');

        $paymentRequired = [
            'x402Version' => 2,
            'accepts' => [
                [
                    'scheme' => 'exact',
                    'network' => $network,
                    'maxAmountRequired' => $this->priceToAtomic($routeConfig['price']),
                    'resource' => $routeConfig['route'],
                    'description' => $routeConfig['description'] ?? '',
                    'mimeType' => $routeConfig['mime_type'] ?? 'application/json',
                    'payTo' => $walletAddress,
                    'maxTimeoutSeconds' => 60,
                    'asset' => 'USDC',
                    'extra' => [
                        'name' => 'EU VAT Info',
                        'url' => config('app.url'),
                    ],
                ],
            ],
            'error' => $error,
        ];

        $encoded = base64_encode(json_encode($paymentRequired));

        return response()->json([
            'error' => $error ?? 'Payment Required',
            'x402' => $paymentRequired,
        ], 402, [
            'PAYMENT-REQUIRED' => $encoded,
        ]);
    }

    /**
     * Verify a payment payload via the x402 facilitator.
     */
    protected function verifyPayment(string $paymentSignature, array $routeConfig): array
    {
        $facilitatorUrl = config('x402.facilitator_url');
        $walletAddress = config('x402.wallet_address');
        $network = config('x402.network');

        try {
            $payload = json_decode(base64_decode($paymentSignature), true);

            $response = Http::timeout(10)->post("{$facilitatorUrl}/verify", [
                'paymentPayload' => $payload,
                'paymentRequirements' => [
                    'scheme' => 'exact',
                    'network' => $network,
                    'maxAmountRequired' => $this->priceToAtomic($routeConfig['price']),
                    'payTo' => $walletAddress,
                    'asset' => 'USDC',
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();

                return ['valid' => $data['isValid'] ?? false];
            }
        } catch (\Exception $e) {
            Log::warning('x402 payment verification failed', [
                'error' => $e->getMessage(),
                'route' => $routeConfig['route'] ?? 'unknown',
            ]);
        }

        return ['valid' => false];
    }

    /**
     * Settle a verified payment via the x402 facilitator.
     */
    protected function settlePayment(string $paymentSignature, array $routeConfig): void
    {
        $facilitatorUrl = config('x402.facilitator_url');
        $walletAddress = config('x402.wallet_address');
        $network = config('x402.network');

        try {
            $payload = json_decode(base64_decode($paymentSignature), true);

            Http::timeout(30)->post("{$facilitatorUrl}/settle", [
                'paymentPayload' => $payload,
                'paymentRequirements' => [
                    'scheme' => 'exact',
                    'network' => $network,
                    'maxAmountRequired' => $this->priceToAtomic($routeConfig['price']),
                    'payTo' => $walletAddress,
                    'asset' => 'USDC',
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('x402 payment settlement failed', [
                'error' => $e->getMessage(),
                'route' => $routeConfig['route'] ?? 'unknown',
            ]);
        }
    }

    /**
     * Convert a dollar price string (e.g., "$0.01") to USDC atomic units (6 decimals).
     */
    protected function priceToAtomic(string $price): string
    {
        $amount = (float) str_replace('$', '', $price);

        return (string) (int) ($amount * 1_000_000);
    }
}
