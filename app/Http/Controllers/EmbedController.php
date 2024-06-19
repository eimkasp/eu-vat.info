<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class EmbedController extends Controller
{
    //
    public function index(Request $request)
    {
        $country = $request->country;
        if($country == null) {
            $country = 'united-kingdom';
        }

        $selectedCountry = Country::where('slug', $country)->first();

        return view('widget.embed', compact(['country', 'selectedCountry']));
    }

    public function iframe(Request $request)
    {
        $country = $request->country;
        if($country == null) {
            $country = 'united-kingdom';
        }
        return view('widget.iframe', compact('country'));
    }
}
