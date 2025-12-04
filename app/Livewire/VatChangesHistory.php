<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\VatRate;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
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
        // Calculate stability indicator (number of changes per country since 2000)
        $this->countryStats = Cache::remember('vat_stats_history', 3600, function () {
            return Country::withCount(['vatRates' => function ($query) {
                $query->where('effective_from', '>=', '2000-01-01');
            }])
                ->get()
                ->map(function ($country) {
                    return [
                        'id' => $country->id,
                        'name' => $country->name,
                        'slug' => $country->slug,
                        'iso_code' => $country->iso_code,
                        'changes_count' => $country->vat_rates_count,
                        'stability' => $this->getStabilityRating($country->vat_rates_count),
                    ];
                })
                ->sortBy('changes_count')
                ->values();
        });
    }

    private function getStabilityRating($changesCount)
    {
        if ($changesCount <= 2) {
            return 'excellent';
        }
        if ($changesCount <= 5) {
            return 'good';
        }
        if ($changesCount <= 10) {
            return 'moderate';
        }

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
