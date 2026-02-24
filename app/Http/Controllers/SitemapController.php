<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Services\SitemapGenerator;

class SitemapController extends Controller
{
    public function index(SitemapGenerator $generator)
    {
        $xml = $generator->generate();

        return response($xml, 200)
            ->header('Content-Type', 'application/xml')
            ->header('Cache-Control', 'public, max-age=3600');
    }
}
