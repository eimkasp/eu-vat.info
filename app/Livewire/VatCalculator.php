<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\CountryAnalytic;
use App\Services\CountryAnalyticsService;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\Attributes\Url;
use Mary\Traits\Toast;
use App\Traits\TracksCountryViews;

// Remove the Number import if it exists
// use Illuminate\Support\Number;

class VatCalculator extends Component
{
    use Toast, TracksCountryViews;

    #[Url]
    public $amount = 100;
    public $country = null;
    public $vat = 0;
    public $slug = 'lithuania-lt';

    public $vat_amount = 0;

    public $total = 0;
    public $result = 0; // Add this property
    #[Url]
    public $selectedRate = 0;
    #[Url]
    public $vat_included = 'include';

    public $rates = [];
    public $customRate = null;
    public $useCustomRate = false;

    public $vat_options = [
        [
            'id' => 1,
            'name' => 'Price includes VAT',
            'value' => 'include',
        ],
        [
            'id' => 2,
            'name' => 'Price excludes VAT (Add VAT)',
            'value' => 'exclude',
        ],
    ];

    #[Url]
    public $selectedCountry1;
    public $selectedCountry2 = null;
    public $selectedCountryObject = null;

    public $saved_searches = [];

    public $countries;

    private CountryAnalyticsService $analyticsService;

    public $error_message = null;

    public function boot(CountryAnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    public function mount($country = null, $slug = null)
    {
        if ($slug) {
            $this->country = Country::where('slug', $slug)->firstOrFail();
            // Track the view when mounting with a slug
            $this->trackCountryView($this->country, 'calculator-view');
        }
        $this->country = $country;
        $this->countries = Cache::remember('all_countries_with_flags', 600, function () {
            return Country::orderBy('name', 'ASC')->get()->map(function($c) {
                // Calculate flag emoji
                $iso = strtoupper($c->iso_code);
                $flag = '';
                if (strlen($iso) === 2) {
                    $flag = mb_chr(ord($iso[0]) + 127397) . mb_chr(ord($iso[1]) + 127397);
                }
                $c->name_with_flag = $flag . ' ' . $c->name;
                return $c;
            });
        });
        
        if ($slug) {
            $this->selectedCountry1 = $slug;
            $this->slug = $slug;
            $this->selectedCountryObject = Country::where('slug', $this->slug)->first();
        } else {
            // Fallback to Lithuania or first available
            $default = Country::where('name', 'Lithuania')->first() ?? Country::first();
            if ($default) {
                $this->selectedCountry1 = $default->slug;
                $this->slug = $default->slug;
                $this->selectedCountryObject = $default;
            }
        }
        $this->getRates();
        
        // Set initial rate
        if (!$this->selectedRate && count($this->rates) > 0) {
            $this->selectedRate = $this->rates[array_key_first($this->rates)]['value'];
        }
        
        // Calculate initial values
        $this->calculateVat();
        $this->result = $this->total; // Initialize result

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

        // Track saved search
        if ($this->country) {
            $this->analyticsService->trackView(
                $this->country,
                request(),
                'saved',
                [
                    'amount' => $this->amount,
                    'rate_used' => $this->selectedRate,
                    'result' => $this->total,
                    'vat_included' => $this->vat_included
                ]
            );
        }

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
                // Try to keep the same rate value if possible, otherwise reset
                $currentRateValue = $this->selectedRate;
                $rateExists = false;
                foreach ($this->rates as $rate) {
                    if ($rate['value'] == $currentRateValue) {
                        $rateExists = true;
                        break;
                    }
                }
                
                if (!$rateExists) {
                    $this->selectedRate = $this->rates[array_key_first($this->rates)]['value'];
                }
            }
            $this->useCustomRate = false;
            $this->calculateVat();
        }
        
        if ($property === 'customRate') {
            if ($this->useCustomRate && is_numeric($this->customRate)) {
                $this->selectedRate = floatval($this->customRate);
                $this->calculateVat();
            }
        }

        if ($property === 'vat_included') {
            $this->calculateVat();
        }
    }

    public function setCustomRate()
    {
        $this->useCustomRate = true;
        if (is_numeric($this->customRate) && $this->customRate >= 0) {
            $this->selectedRate = floatval($this->customRate);
            $this->calculateVat();
        }
    }

    public function selectPresetRate($rate)
    {
        $this->useCustomRate = false;
        $this->selectedRate = $rate;
        $this->customRate = null;
        $this->calculateVat();
    }

    public function calculate()
    {
        $this->selectedCountryObject = Country::where('slug', $this->slug)->first();
        if ($this->selectedCountryObject) {
            $this->country = $this->selectedCountryObject; // Ensure country is set
            $this->getRates();
            $this->vat = $this->selectedCountryObject->standard_rate;
            $this->calculateVat();
            $this->trackVisit(); // Keep tracking here
        }
    }

    public function render()
    {
        return view('livewire.vat-calculator');
    }

    private function calculateVat()
    {
        $this->error_message = null;

        try {
            // If amount is already numeric (float/int), use it directly
            // Otherwise normalize European format strings like '1.234,56'
            if (is_numeric($this->amount)) {
                $amount = round(floatval($this->amount), 2);
            } else {
                $cleanAmount = $this->normalizeNumber($this->amount);
                $amount = round(floatval($cleanAmount), 2);
            }
            
            if (!$this->isValidAmount($amount)) {
                throw new \InvalidArgumentException("Please enter a valid positive number");
            }

            $this->amount = $amount;

            if (!$this->selectedRate) {
                $this->resetCalculation();
                return;
            }

            $rate = floatval($this->selectedRate);
            $this->calculateTotals($amount, $rate);

        } catch (\Exception $e) {
            $this->handleCalculationError($e->getMessage());
        }
    }

    private function normalizeNumber($input): string 
    {
        // Handle European number format
        $cleaned = str_replace(['.', ','], ['', '.'], $input);
        return preg_replace('/[^0-9.]/', '', $cleaned);
    }

    private function isValidAmount($amount): bool
    {
        return is_numeric($amount) && $amount >= 0;
    }

    private function calculateTotals($amount, $rate)
    {
        if ($this->vat_included == 'include') {
            // Input is Gross (Total)
            // Formula: VAT = Total - (Total / (1 + rate/100))
            $this->vat_amount = round($amount - ($amount / (1 + ($rate / 100))), 2);
            $this->total = round($amount, 2);
        } else {
            // Input is Net
            // Formula: VAT = Net * (rate/100)
            $this->vat_amount = round($amount * ($rate / 100), 2);
            $this->total = round($amount + $this->vat_amount, 2);
        }

        $this->amount = (float)$amount;
        $this->total = (float)$this->total;
        $this->vat_amount = (float)$this->vat_amount;
    }

    private function resetCalculation()
    {
        $this->total = 0;
        $this->vat_amount = 0;
    }

    private function handleCalculationError($message)
    {
        $this->error_message = $message;
        $this->resetCalculation();
        $this->amount = 0;
    }

    private function getRates()
    {
        $this->rates = [];
        if ($this->selectedCountryObject) {
            // Try to get rates from VatRate model for the current date
            $date = now()->format('Y-m-d');
            
            $historicalRates = \App\Models\VatRate::where('country_id', $this->selectedCountryObject->id)
                ->where('effective_from', '<=', $date)
                ->where(function ($query) use ($date) {
                    $query->where('effective_to', '>=', $date)
                          ->orWhereNull('effective_to');
                })
                ->get();

            $id = 1;
            $addedTypes = [];

            // 1. Add rates from VatRate table (Historical/Specific)
            if ($historicalRates->isNotEmpty()) {
                foreach ($historicalRates as $rate) {
                    $type = strtolower($rate->type);
                    if (!in_array($type, $addedTypes)) {
                        $name = ucfirst(str_replace('_', ' ', $rate->type)) . ' rate';
                        $this->rates[] = [
                            'id' => $id++,
                            'name' => $name . ' (' . $rate->rate . '%)',
                            'value' => $rate->rate,
                        ];
                        $addedTypes[] = $type;
                    }
                }
            }

            // 2. Add rates from Country model (Current snapshot) if not already added
            $snapshotRates = [
                'standard' => ['name' => 'Standard rate', 'value' => $this->selectedCountryObject->standard_rate],
                'reduced' => ['name' => 'Reduced rate', 'value' => $this->selectedCountryObject->reduced_rate],
                'zero' => ['name' => 'Zero rate', 'value' => $this->selectedCountryObject->zero_rate],
                'super_reduced' => ['name' => 'Super reduced rate', 'value' => $this->selectedCountryObject->super_reduced_rate],
                'parking' => ['name' => 'Parking rate', 'value' => $this->selectedCountryObject->parking_rate],
            ];

            foreach ($snapshotRates as $type => $data) {
                // Check if type already added (fuzzy match for types like 'standard_rate' vs 'standard')
                $alreadyAdded = false;
                foreach ($addedTypes as $addedType) {
                    if (str_contains($addedType, $type) || str_contains($type, $addedType)) {
                        $alreadyAdded = true;
                        break;
                    }
                }

                if (!$alreadyAdded && $data['value'] !== null && $data['value'] > 0) {
                    $this->rates[] = [
                        'id' => $id++,
                        'name' => $data['name'] . ' (' . $data['value'] . '%)',
                        'value' => $data['value'],
                    ];
                }
            }

            // If absolutely no rates found, default to 0
            if (empty($this->rates)) {
                $this->rates[] = [
                    'id' => 1,
                    'name' => 'Standard rate (0%)',
                    'value' => 0,
                ];
            }
        }
    }

    protected function trackVisit()
    {
        if (!$this->country) return;

        $this->analyticsService->trackView(
            $this->country,
            request(),
            'calculator',
            [
                'amount' => $this->amount,
                'rate_used' => $this->selectedRate,
                'result' => $this->total // Changed from $this->result to $this->total
            ]
        );
    }
}
