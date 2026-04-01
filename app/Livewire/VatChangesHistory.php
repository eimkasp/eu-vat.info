<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\VatRateChange;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class VatChangesHistory extends Component
{
    use WithPagination;

    #[Url(as: 'country')]
    public $selectedCountry = '';

    #[Url(as: 'type')]
    public $selectedType = '';

    #[Url(as: 'direction')]
    public $selectedDirection = '';

    public $countryStats = [];

    public function mount()
    {
        $this->loadCountryStats();
    }

    public function updatedSelectedCountry()
    {
        $this->resetPage();
    }

    public function updatedSelectedType()
    {
        $this->resetPage();
    }

    public function updatedSelectedDirection()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->selectedCountry = '';
        $this->selectedType = '';
        $this->selectedDirection = '';
        $this->resetPage();
    }

    public function loadCountryStats()
    {
        $this->countryStats = Cache::remember('vat_change_stats', 3600, function () {
            return Country::withCount(['vatRateChanges'])
                ->get()
                ->map(function ($country) {
                    return [
                        'id' => $country->id,
                        'name' => $country->name,
                        'slug' => $country->slug,
                        'iso_code' => $country->iso_code,
                        'changes_count' => $country->vat_rate_changes_count,
                        'stability' => $this->getStabilityRating($country->vat_rate_changes_count),
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

    public function hasActiveFilters(): bool
    {
        return $this->selectedCountry !== '' || $this->selectedType !== '' || $this->selectedDirection !== '';
    }

    public function render()
    {
        $query = VatRateChange::with('country')
            ->orderBy('change_date', 'desc');

        if ($this->selectedCountry) {
            $query->where('country_id', $this->selectedCountry);
        }

        if ($this->selectedType) {
            $query->where('rate_type', $this->selectedType);
        }

        if ($this->selectedDirection) {
            $query->where('change_direction', $this->selectedDirection);
        }

        $changes = $query->paginate(20);

        $countries = Cache::remember('countries_list_ordered', 3600, function () {
            return Country::orderBy('name')->get();
        });

        return view('livewire.vat-changes-history', [
            'changes' => $changes,
            'countries' => $countries,
            'hasFilters' => $this->hasActiveFilters(),
        ]);
    }
}
