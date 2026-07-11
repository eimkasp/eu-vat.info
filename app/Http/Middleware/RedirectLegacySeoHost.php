<?php

namespace App\Http\Middleware;

use App\Support\Seo\SeoPolicy;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectLegacySeoHost
{
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array($request->getHost(), config('seo.legacy_hosts', []), true)) {
            $target = app(SeoPolicy::class)->canonicalHost().'/'.ltrim($request->getRequestUri(), '/');

            return redirect()->away($target, 301);
        }

        return $next($request);
    }
}
