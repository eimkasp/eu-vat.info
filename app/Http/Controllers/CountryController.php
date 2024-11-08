<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Services\CountryAnalyticsService;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct(
        private readonly CountryAnalyticsService $analyticsService
    ) {}

    // this is api controller create rest endpoints 

    public function index()
    {
        $countries = Country::all();
        return response()->json($countries);
    }

    public function show(Request $request, Country $country)
    {
        $this->analyticsService->trackView($country, $request);
        
        // Your existing show logic
        return view('countries.show', compact('country'));
    }

    public function calculator(Request $request, Country $country)
    {
        $amount = $request->input('amount');
        $rate = $request->input('rate', $country->standard_rate);

        $this->analyticsService->trackView($country, $request, 'calculator', [
            'amount' => $amount,
            'rate_used' => $rate,
            'calculation_type' => $request->input('type', 'add')
        ]);

        // Your existing calculator logic
        return view('calculator', compact('country'));
    }
}
