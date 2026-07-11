<?php

namespace App\Livewire;

use App\Services\Seo\VatCategorySeoService;
use Livewire\Component;

class VatCategoryHub extends Component
{
    public string $category;

    public function mount(string $category, VatCategorySeoService $categories): void
    {
        abort_unless($categories->categoryIsEligible($category), 404);

        $this->category = $category;
    }

    public function render(VatCategorySeoService $categories)
    {
        $summary = $categories->eligibleCategories()->firstWhere('slug', $this->category);

        abort_unless($summary, 404);

        return view('livewire.vat-category-hub', [
            'summary' => $summary,
            'rules' => $categories->rulesForCategory($this->category),
        ]);
    }
}
