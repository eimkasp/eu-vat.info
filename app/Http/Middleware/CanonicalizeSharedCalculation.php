<?php

namespace App\Http\Middleware;

use App\Livewire\SharedCalculation;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanonicalizeSharedCalculation
{
    public function handle(Request $request, Closure $next): Response
    {
        $amount = (string) $request->route('amount');
        $rate = (string) $request->route('rate');

        if ($amount === SharedCalculation::segment($amount) && $rate === SharedCalculation::segment($rate)) {
            return $next($request);
        }

        $url = SharedCalculation::calculationUrl((string) $request->route('country'), $amount, $rate, (string) $request->route('mode'));
        $query = $request->getQueryString();

        return redirect()->to($query ? $url.'?'.$query : $url, 301);
    }
}
