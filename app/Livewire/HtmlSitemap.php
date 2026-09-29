<?php

namespace App\Livewire;

use App\Models\Country;
use App\Services\BlogPostRepository;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class HtmlSitemap extends Component
{
    public function render()
    {
        $countries = Cache::remember('html_sitemap_countries_v2', 3600, fn () => Country::query()
            ->calculatorAvailable()
            ->withExists(['vatRates', 'vatRateChanges'])
            ->orderBy('name')
            ->get());

        return view('livewire.html-sitemap', [
            'groups' => [
                'eu' => $countries->where('is_eu_member', true)->values(),
                'other_europe' => $countries->where('is_eu_member', false)->values(),
            ],
            'blogPosts' => app(BlogPostRepository::class)->all(),
        ]);
    }
}
