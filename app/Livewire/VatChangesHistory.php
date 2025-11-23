<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\VatRate;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class VatChangesHistory extends Component
{
    use WithPagination;

    public $selectedCountry = null;
    public $selectedType = null;
    public $sortBy = 'recent'; // recent, country, stability
    public $countryStats = [];

    public function mount()
    {
        $this->loadCountryStats();
    }

    public function loadCountryStats()
    {
        // Calculate stability indicator (number of changes per country)
        $this->countryStats = Country::withCount(['vatRates' => function ($query) {
            $query->where('effective_from', '>=', now()->subYears(10));
        }])
        ->get()
        ->map(function ($country) {
            return [
                'id' => $country->id,
                'name' => $country->name,
                'slug' => $country->slug,
                'iso_code_2' => $country->iso_code_2,
                'changes_count' => $country->vat_rates_count,
                'stability' => $this->getStabilityRating($country->vat_rates_count)
            ];
        })
        ->sortBy('changes_count')
        ->values();
    }

    private function getStabilityRating($changesCount)
    {
        if ($changesCount <= 2) return 'excellent';
        if ($changesCount <= 5) return 'good';
        if ($changesCount <= 10) return 'moderate';
        return 'frequent';
    }

    public function render()
    {
        $query = VatRate::with('country')
            ->where('effective_from', '>=', now()->subYears(10))
            ->orderBy('effective_from', 'desc');

        if ($this->selectedCountry) {
            $query->where('country_id', $this->selectedCountry);
        }

        if ($this->selectedType) {
            $query->where('type', $this->selectedType);
        }

        $changes = $query->paginate(20);

        return view('livewire.vat-changes-history', [
            'changes' => $changes,
            'countries' => Country::orderBy('name')->get(),
        ]);
    }
}
