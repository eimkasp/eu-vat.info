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
       $sitemap =  Sitemap::create()
            ->add(Country::all())
            ->add('/embed')
            ->add('/');

            foreach(Country::all() as $country) {
                $sitemap->add(Url::create('/embed/' . $country->slug)->setLastModificationDate(Carbon::now()));
            }

        $sitemap->writeToFile('sitemap.xml');
           
    }
}
