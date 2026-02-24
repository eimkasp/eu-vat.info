<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\VatRate;
use Livewire\Component;

class VatRateHistoryChart extends Component
{
    public $country;
    public $chartData = [];
    public $rateChange = null;
    public $totalChanges = 0;
    public $earliestRate = null;
    public $currentRate = null;
    public $changePercentage = null;

    public function mount($country = null)
    {
        $this->country = $country ?? Country::first();
        if (!$this->country) {
            return;
        }
        $this->loadChartData();
        $this->calculateStats();
    }

    public function loadChartData()
    {
        if (!$this->country) {
            $this->chartData = [['name' => 'Standard Rate', 'data' => []]];
            return;
        }
        $country_id_to_use = $this->country->id;

        $rates = VatRate::where('country_id', $country_id_to_use)
            ->where('type', 'standard')
            ->where('effective_from', '>=', '2000-01-01')
            ->orderBy('effective_from', 'asc')
            ->get();

        $this->totalChanges = $rates->count();

        $data = [];
        foreach ($rates as $rate) {
            $data[] = [
                'x' => $rate->effective_from->format('Y-m-d'),
                'y' => $rate->rate,
            ];
        }

        $this->chartData = [['name' => 'Standard Rate', 'data' => $data]];
    }

    private function calculateStats()
    {
        if (!$this->country) {
            return;
        }
        $country_id_to_use = $this->country->id;

        
        $earliest = VatRate::where('country_id', $country_id_to_use)
            ->where('type', 'standard')
            ->where('effective_from', '>=', '2000-01-01')
            ->orderBy('effective_from', 'asc')
            ->first();

        $current = VatRate::where('country_id', $country_id_to_use)
            ->where('type', 'standard')
            ->where(function ($query) {
                $query->whereNull('effective_to')
                    ->orWhere('effective_to', '>=', now());
            })
            ->orderBy('effective_from', 'desc')
            ->first();

        if ($earliest && $current) {
            $this->earliestRate = $earliest->rate;
            $this->currentRate = $current->rate;
            $this->rateChange = $current->rate - $earliest->rate;

            if ($earliest->rate > 0) {
                $this->changePercentage = ($this->rateChange / $earliest->rate) * 100;
            }
        }
    }

    public function render()
    {
        return view('livewire.vat-rate-history-chart');
    }
}
