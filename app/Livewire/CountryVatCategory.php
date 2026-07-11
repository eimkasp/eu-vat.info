<?php

namespace App\Livewire;

use App\Models\VatRateRule;
use App\Services\Seo\VatCategorySeoService;
use Livewire\Component;

class CountryVatCategory extends Component
{
    public VatRateRule $rule;

    public function mount(string $country, string $category, VatCategorySeoService $categories): void
    {
        $rule = $categories->ruleForCountry($country, $category);

        abort_unless($rule, 404);

        $this->rule = $rule;
    }

    public function render(VatCategorySeoService $categories)
    {
        return view('livewire.country-vat-category', [
            'categoryHubAvailable' => $categories->categoryIsEligible($this->rule->category_slug),
        ]);
    }
}
