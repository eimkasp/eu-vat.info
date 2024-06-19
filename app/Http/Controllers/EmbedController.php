<?php

namespace App\Http\Controllers;

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
        return view('widget.embed', compact('country'));
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
