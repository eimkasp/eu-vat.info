<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;
use Spatie\Sitemap\Sitemap;

class SitemapController extends Controller
{
    //
    public function index()
    {
        Sitemap::create()
            ->add(Country::all())
            ->writeToFile('sitemap.xml');
    }
}
