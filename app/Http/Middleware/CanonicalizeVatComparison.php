<?php

namespace App\Http\Middleware;

use App\Services\Seo\InternalLinkService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanonicalizeVatComparison
{
    public function handle(Request $request, Closure $next): Response
    {
        $pair = (string) $request->route('pair');

        if (preg_match('/^(.+)-vs-(.+)$/', $pair, $matches)) {
            $requested = [$matches[1], $matches[2]];
            $canonical = app(InternalLinkService::class)->canonicalPair(...$requested);

            if ($canonical && $requested !== $canonical) {
                return redirect()->to(locale_path('/compare/'.implode('-vs-', $canonical).'-vat'), 301);
            }
        }

        return $next($request);
    }
}
