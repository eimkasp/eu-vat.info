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
    public $selectedCountry1 = 'lithuania-lt';
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
        if($slug) {
            $this->selectedCountry1 = $slug;
        }
        $this->selectedCountryObject = Country::where('slug', $this->selectedCountry1)->first();
        $this->getRates();
        $this->saved_searches = session()->get('saved_searched');

        if(is_array($this->saved_searches)) {
            $this->saved_searches = array_reverse($this->saved_searches);
            $this->saved_searches = array_slice($this->saved_searches, 0, 8);
        } else {
            $this->saved_searches = [];
        }
      

    }

    public function saveSearch() {
        // Save user parameters to session
        session()->push('saved_searched', [
            'amount' => $this->amount,
            'selectedCountry1' => $this->selectedCountry1,
            'selectedRate' => $this->selectedRate,
            'vat_included' => $this->vat_included,
        ]);

        $this->success('Your search has been saved!', 'Success',  position: 'toast-bottom toast-start');
        // Triger re-render
        $this->saved_searches = session()->get('saved_searched');
        $this->saved_searches = array_reverse($this->saved_searches);
        $this->saved_searches = array_slice($this->saved_searches, 0, 8);


    }

    public function clearSearch() {
        session()->forget('saved_searched');
        $this->success('Your search has been cleared!', 'Success',  position: 'toast-bottom toast-start');
        // Triger re-render
        $this->saved_searches = [];
    }

    public function updatedSelectedCountry()
    {
        $this->selectedRate = null;
        $this->getRates();
        $this->calculateVat();
    }

    public function calculate()
    {
        $this->getRates();
        $this->selectedCountryObject = Country::where('slug', $this->selectedCountry1)->first();
        $this->vat = $this->selectedCountryObject->standard_rate;
        $this->calculateVat();
    }
    public function render()
    {
        return view('livewire.vat-calculator');
    }

    private function calculateVat()
    {
        if ($this->vat_included == 'include') {
            $this->total = $this->amount * (1 + $this->selectedRate / 100);
          
            $this->vat_amount = $this->amount - $this->total;
        } else {
            $this->total = $this->amount / (1 + $this->selectedRate / 100);
            
        }

        $this->vat_amount = $this->total - $this->amount;
    }

    private function getRates()
    {
        $this->rates = [
            [
                'id' => 1,
                'name' => $this->selectedCountryObject->standard_rate . '%',
                'value' => $this->selectedCountryObject->standard_rate,
            ],
            [
                'id' => 2,
                'name' => $this->selectedCountryObject->reduced_rate . '%',
                'value' => $this->selectedCountryObject->reduced_rate,
            ],
            [
                'id' => 3,
                'name' => $this->selectedCountryObject->zero_rate . '%',
                'value' => $this->selectedCountryObject->zero_rate,
            ],
            [
                'id' => 4,
                'name' => $this->selectedCountryObject->super_reduced_rate . '%',
                'value' => $this->selectedCountryObject->zero_rate,
            ],
        ];

        $this->rates = array_filter($this->rates, function ($rate) {
            return $rate['value'] > 0;
        });

        if(!$this->selectedRate) {
            $this->selectedRate = $this->rates[0]['value'];
        }
    }
}
