<?php

namespace App\Livewire;

use App\Services\Seo\VatCategorySeoService;
use Livewire\Component;

class VatCategoryIndex extends Component
{
    public function mount(VatCategorySeoService $categories): void
    {
        abort_if($categories->eligibleCategories()->isEmpty(), 404);
    }

    public function render(VatCategorySeoService $categories)
    {
        return view('livewire.vat-category-index', [
            'categories' => $categories->eligibleCategories(),
        ]);
    }
}
