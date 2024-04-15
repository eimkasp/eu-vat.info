<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    //
    // this is api controller create rest endpoints 

    public function index()
    {
        $countries = Country::all();
        return response()->json($countries);
    }

}
