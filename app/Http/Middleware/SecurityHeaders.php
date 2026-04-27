<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * External script sources required by the application.
     * - stats.businesspress.io: Plausible analytics
     * - pagead2.googlesyndication.com: Google AdSense
     * - cdn.jsdelivr.net: ApexCharts (history chart)
     */
    private const SCRIPT_SOURCES = [
        "'self'",
        "'unsafe-inline'", // Required by Livewire 3, Alpine.js, and SW registration
        'https://pagead2.googlesyndication.com',
        'https://stats.businesspress.io',
        'https://cdn.jsdelivr.net',
    ];

    private const STYLE_SOURCES = [
        "'self'",
        "'unsafe-inline'", // Required by Tailwind/DaisyUI and Livewire
    ];

    private const IMG_SOURCES = [
        "'self'",
        'data:',
        'https://flagcdn.com',
        'https://*.googlesyndication.com', // AdSense
    ];

    private const CONNECT_SOURCES = [
        "'self'",
        'https://stats.businesspress.io', // Plausible beacon
    ];

    /**
     * AdSense renders ads in iframes from these origins.
     */
    private const FRAME_SOURCES = [
        'https://*.googlesyndication.com',
        'https://*.doubleclick.net',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prevent MIME-type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Clickjacking protection (AllowEmbedding middleware removes this for embed routes)
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Force HTTPS for 1 year, include subdomains
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');

        // Stop leaking referrer info to third parties
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Disable browser features not used by this app
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        // Full Content-Security-Policy
        $response->headers->set('Content-Security-Policy', $this->buildCsp());

        return $response;
    }

    private function buildCsp(): string
    {
        $directives = [
            "default-src 'self'",
            'script-src ' . implode(' ', self::SCRIPT_SOURCES),
            'style-src ' . implode(' ', self::STYLE_SOURCES),
            'img-src ' . implode(' ', self::IMG_SOURCES),
            "font-src 'self'",
            'connect-src ' . implode(' ', self::CONNECT_SOURCES),
            'frame-src ' . implode(' ', self::FRAME_SOURCES),
            "object-src 'none'",   // No Flash/plugins
            "base-uri 'self'",     // Prevent base-tag injection
            "frame-ancestors 'self'", // AllowEmbedding will override this for embed routes
            "form-action 'self'",
        ];

        return implode('; ', $directives);
    }
}
