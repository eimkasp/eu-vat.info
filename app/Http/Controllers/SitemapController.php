<?php

namespace App\Http\Controllers;

use App\Services\SitemapGenerator;

class SitemapController extends Controller
{
    public function index(SitemapGenerator $generator)
    {
        return $this->xml($generator->generateIndex());
    }

    public function section(string $section, SitemapGenerator $generator)
    {
        return $this->xml($generator->generateSection($section));
    }

    protected function xml(string $xml)
    {
        return response($xml, 200)
            ->header('Content-Type', 'application/xml')
            ->header('Cache-Control', 'public, max-age=3600');
    }
}
