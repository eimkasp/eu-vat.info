<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllowEmbedding
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Remove the restrictive X-Frame-Options set by SecurityHeaders middleware
        $response->headers->remove('X-Frame-Options');

        // Patch only the frame-ancestors directive in the existing CSP so all
        // other directives (script-src, object-src, etc.) remain intact.
        $existingCsp = $response->headers->get('Content-Security-Policy', '');

        if ($existingCsp !== '') {
            // Replace existing frame-ancestors directive value
            $newCsp = preg_replace('/frame-ancestors[^;]+(;|$)/', 'frame-ancestors *$1', $existingCsp);
            // If no frame-ancestors directive existed yet, append one
            if ($newCsp === $existingCsp && ! str_contains($existingCsp, 'frame-ancestors')) {
                $newCsp = rtrim($existingCsp, '; ') . '; frame-ancestors *';
            }
        } else {
            $newCsp = "frame-ancestors *";
        }

        $response->headers->set('Content-Security-Policy', $newCsp);

        // Flag this session so EmbedCookieFix (global middleware) can identify
        // subsequent Livewire AJAX requests that belong to an embed context.
        if ($request->hasSession()) {
            $request->session()->put('_embed_context', true);
        }

        return $response;
    }
}
