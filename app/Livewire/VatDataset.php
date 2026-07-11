<?php

namespace App\Livewire;

use App\Models\Country;
use Carbon\CarbonImmutable;
use Livewire\Component;

class VatDataset extends Component
{
    public function render()
    {
        $countries = Country::query()
            ->where('is_eu_member', true)
            ->orderBy('name')
            ->get();

        $latestUpdate = $countries->max('updated_at');
        $dateModified = $latestUpdate
            ? CarbonImmutable::parse($latestUpdate)
            : now()->startOfDay()->toImmutable();

        return view('livewire.vat-dataset', [
            'countries' => $countries,
            'dateModified' => $dateModified,
        ]);
    }
}
