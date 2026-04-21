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

        $response->headers->remove('X-Frame-Options');
        $response->headers->set('Content-Security-Policy', "frame-ancestors *");

        // Flag this session so EmbedCookieFix (global middleware) can identify
        // subsequent Livewire AJAX requests that belong to an embed context.
        if ($request->hasSession()) {
            $request->session()->put('_embed_context', true);
        }

        return $response;
    }
}
