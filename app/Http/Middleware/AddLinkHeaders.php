<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddLinkHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->path() === '/' || $request->path() === '') {
            $links = [
                '</.well-known/api-catalog>; rel="api-catalog"',
                '</llms.txt>; rel="service-doc"; title="LLM-friendly documentation"',
                '</sitemap.xml>; rel="describedby"; type="application/xml"',
            ];

            $response->headers->set('Link', implode(', ', $links));
        }

        return $response;
    }
}
