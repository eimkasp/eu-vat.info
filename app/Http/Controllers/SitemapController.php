<?php

namespace App\Http\Controllers;

use App\Models\Country;

class SitemapController extends Controller
{
    public function index()
    {
        $countries = Country::all();

        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Homepage
        $sitemap .= '<url>';
        $sitemap .= '<loc>'.url('/').'</loc>';
        $sitemap .= '<lastmod>'.now()->toAtomString().'</lastmod>';
        $sitemap .= '<changefreq>daily</changefreq>';
        $sitemap .= '<priority>1.0</priority>';
        $sitemap .= '</url>';

        // Main calculator page
        $sitemap .= '<url>';
        $sitemap .= '<loc>'.route('vat-calculator').'</loc>';
        $sitemap .= '<lastmod>'.now()->toAtomString().'</lastmod>';
        $sitemap .= '<changefreq>weekly</changefreq>';
        $sitemap .= '<priority>0.9</priority>';
        $sitemap .= '</url>';

        // VAT changes history
        $sitemap .= '<url>';
        $sitemap .= '<loc>'.route('vat-changes').'</loc>';
        $sitemap .= '<lastmod>'.now()->toAtomString().'</lastmod>';
        $sitemap .= '<changefreq>weekly</changefreq>';
        $sitemap .= '<priority>0.8</priority>';
        $sitemap .= '</url>';

        // VAT map
        $sitemap .= '<url>';
        $sitemap .= '<loc>'.route('vat-map').'</loc>';
        $sitemap .= '<lastmod>'.now()->toAtomString().'</lastmod>';
        $sitemap .= '<changefreq>monthly</changefreq>';
        $sitemap .= '<priority>0.7</priority>';
        $sitemap .= '</url>';

        // Country-specific calculator pages & detail pages
        foreach ($countries as $country) {
            // Calculator Page
            $sitemap .= '<url>';
            $sitemap .= '<loc>'.route('vat-calculator.country', $country->slug).'</loc>';
            $sitemap .= '<lastmod>'.$country->updated_at->toAtomString().'</lastmod>';
            $sitemap .= '<changefreq>monthly</changefreq>';
            $sitemap .= '<priority>0.8</priority>';
            $sitemap .= '</url>';

            // Detail Page
            $sitemap .= '<url>';
            $sitemap .= '<loc>'.route('country.show', $country->slug).'</loc>';
            $sitemap .= '<lastmod>'.$country->updated_at->toAtomString().'</lastmod>';
            $sitemap .= '<changefreq>monthly</changefreq>';
            $sitemap .= '<priority>0.9</priority>';
            $sitemap .= '</url>';
        }

        $sitemap .= '</urlset>';

        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }
}
