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
        $countries = Cache::remember('sitemap_countries', 3600, function () {
            return Country::orderBy('name')->get();
        });

        return view('livewire.html-sitemap', [
            'countries' => $countries,
            'blogPosts' => app(BlogPostRepository::class)->all(),
        ]);
    }
}
