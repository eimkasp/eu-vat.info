<?php

namespace App\Livewire;

use App\Models\Country;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\Attributes\Url;
use Mary\Traits\Toast;


class VatCalculator extends Component
{
    #[Url]
    public $amount = 100;
    public $country = null;
    public $vat = 0;
    public $slug = 'lithuania-lt';

    public $vat_amount = 0;

    public $total = 0;
    #[Url]
    public $selectedRate = 0;
    #[Url]
    public $vat_included = 'include';

    public $rates = [];

    public $vat_options = [
        [
            'id' => 1,
            'name' => 'Include VAT',
            'value' => 'include',
        ],
        [
            'id' => 2,
            'name' => 'Exclude VAT',
            'value' => 'exclude',
        ],
    ];

    #[Url]
    public $selectedCountry1;
    public $selectedCountry2 = null;
    public $selectedCountryObject = null;

    public $saved_searches = [];

    public $countries;

    use Toast;
    public function mount($country = null, $slug = null)
    {
        $this->country = $country;
        $this->countries = Cache::remember('all_countries', 600, function () {
            return Country::orderBy('name', 'ASC')->get();
        });
        
        if ($slug) {
            $this->selectedCountry1 = $slug;
            $this->slug = $slug;
        } else {
            $this->selectedCountry1 = 'lithuania-lt';
            $this->slug = 'lithuania-lt';
        }

        $this->selectedCountryObject = Country::where('slug', $this->slug)->first();
        $this->getRates();
        
        // Set initial rate
        if (!$this->selectedRate && count($this->rates) > 0) {
            $this->selectedRate = $this->rates[array_key_first($this->rates)]['value'];
        }
        
        // Calculate initial values
        $this->calculateVat();

        // Load saved searches
        $this->saved_searches = session()->get('saved_searched', []);
        if (is_array($this->saved_searches)) {
            $this->saved_searches = array_slice(array_reverse($this->saved_searches), 0, 8);
        }
    }

    public function saveSearch()
    {
        // Save user parameters to session
        session()->push('saved_searched', [
            'amount' => $this->amount,
            'selectedCountry1' => $this->selectedCountry1,
            'selectedRate' => $this->selectedRate,
            'vat_included' => $this->vat_included,
        ]);

        $this->success('Your search has been saved!', 'Success', position: 'toast-bottom toast-start');
        // Triger re-render
        $this->saved_searches = session()->get('saved_searched');
        $this->saved_searches = array_reverse($this->saved_searches);
        $this->saved_searches = array_slice($this->saved_searches, 0, 8);


    }

    public function clearSearch()
    {
        session()->forget('saved_searched');
        $this->success('Your search has been cleared!', 'Success', position: 'toast-bottom toast-start');
        // Triger re-render
        $this->saved_searches = [];
    }

    public function updated($property)
    {
        if ($property === 'selectedCountry1') {
            $this->slug = $this->selectedCountry1;
            $this->selectedCountryObject = Country::where('slug', $this->slug)->first();
            $this->getRates();
            // Reset rate to standard rate when changing country
            if (count($this->rates) > 0) {
                $this->selectedRate = $this->rates[array_key_first($this->rates)]['value'];
            }
            $this->calculateVat();
        }
    }

    public function calculate()
    {
        $this->selectedCountryObject = Country::where('slug', $this->slug)->first();
        if ($this->selectedCountryObject) {
            $this->getRates();
            $this->vat = $this->selectedCountryObject->standard_rate;
            $this->calculateVat();
        }

    }
    public function render()
    {
        return view('livewire.vat-calculator');
    }

    private function calculateVat()
    {
        if (!$this->amount || !$this->selectedRate) {
            $this->total = 0;
            $this->vat_amount = 0;
            return;
        }

        if ($this->vat_included == 'include') {
            $this->total = $this->amount * (1 + $this->selectedRate / 100);
            $this->vat_amount = $this->total - $this->amount;
        } else {
            $this->total = $this->amount;
            $this->vat_amount = $this->amount * ($this->selectedRate / 100);
        }
    }

    private function getRates()
    {
        $this->rates = [];
        if ($this->selectedCountryObject) {
            $possibleRates = [
                ['name' => 'Standard rate', 'value' => $this->selectedCountryObject->standard_rate],
                ['name' => 'Reduced rate', 'value' => $this->selectedCountryObject->reduced_rate],
                ['name' => 'Zero rate', 'value' => $this->selectedCountryObject->zero_rate],
                ['name' => 'Super reduced rate', 'value' => $this->selectedCountryObject->super_reduced_rate],
            ];

            $id = 1;
            foreach ($possibleRates as $rate) {
                if ($rate['value'] > 0) {
                    $this->rates[] = [
                        'id' => $id++,
                        'name' => $rate['value'] . '%',
                        'value' => $rate['value'],
                    ];
                }
            }
        }
    }
}
