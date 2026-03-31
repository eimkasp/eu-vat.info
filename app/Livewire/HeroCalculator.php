<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\VatRate;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Url;
use Livewire\Component;

class HeroCalculator extends Component
{
    public $amount = 100;

    public $showHeader = true;

    #[Url(as: 'country', history: true)]
    public $selectedCountrySlug = '';

    public $selectedRate = 0;

    public $mode = 'exclude'; // 'include' = extract VAT, 'exclude' = add VAT

    public $customRate = null;

    public $useCustomRate = false;

    public $rates = [];

    public $countries = [];

    public $selectedCountryObject = null;

    public $vat_amount = 0;

    public $total = 0;

    public $net_amount = 0;

    public $error_message = null;

    public $history = [];

    public $showResults = false;

    public function mount($initialCountry = null)
    {
        $this->countries = Cache::remember('hero_calc_countries', 600, function () {
            return Country::orderBy('name', 'ASC')->get()->map(function ($c) {
                $iso = strtoupper($c->iso_code);
                $flag = '';
                if (strlen($iso) === 2) {
                    $flag = mb_chr(ord($iso[0]) + 127397) . mb_chr(ord($iso[1]) + 127397);
                }

                return [
                    'slug' => $c->slug,
                    'name' => $c->name,
                    'flag' => $flag,
                    'iso' => strtolower($c->iso_code),
                    'standard_rate' => $c->standard_rate,
                    'currency_display' => $c->currency_display,
                ];
            })->toArray();
        });

        // Priority: initialCountry prop > URL param > cookie > default (Germany)
        $slugFromUrl = $this->selectedCountrySlug;
        $slugFromCookie = request()->cookie('hero_calc_country');

        if ($initialCountry && collect($this->countries)->firstWhere('slug', $initialCountry)) {
            $this->selectedCountrySlug = $initialCountry;
        } elseif ($slugFromUrl && collect($this->countries)->firstWhere('slug', $slugFromUrl)) {
            // URL param already set by #[Url]
        } elseif ($slugFromCookie && collect($this->countries)->firstWhere('slug', $slugFromCookie)) {
            $this->selectedCountrySlug = $slugFromCookie;
        } else {
            $default = collect($this->countries)->firstWhere('name', 'Germany')
                ?? collect($this->countries)->first();
            $this->selectedCountrySlug = $default['slug'] ?? '';
        }

        if ($this->selectedCountrySlug) {
            $this->loadCountry();
        }

        $this->history = session()->get('hero_calc_history', []);
    }

    public function loadCountry()
    {
        $this->selectedCountryObject = Country::where('slug', $this->selectedCountrySlug)->first();
        $this->loadRates();

        if (!$this->useCustomRate && count($this->rates) > 0) {
            $this->selectedRate = $this->rates[0]['value'];
        }

        $this->calculateVat();
    }

    public function updatedSelectedCountrySlug()
    {
        $this->useCustomRate = false;
        $this->customRate = null;
        $this->loadCountry();

        // Remember selection for 90 days
        cookie()->queue('hero_calc_country', $this->selectedCountrySlug, 60 * 24 * 90);
    }

    public function updatedAmount()
    {
        $this->calculateVat();
    }

    public function updatedMode()
    {
        $this->calculateVat();
    }

    public function updatedCustomRate()
    {
        if ($this->useCustomRate && is_numeric($this->customRate) && $this->customRate >= 0) {
            $this->selectedRate = floatval($this->customRate);
            $this->calculateVat();
        }
    }

    public function selectRate($rate)
    {
        $this->useCustomRate = false;
        $this->customRate = null;
        $this->selectedRate = $rate;
        $this->calculateVat();
    }

    public function enableCustomRate()
    {
        $this->useCustomRate = true;
        if (is_numeric($this->customRate) && $this->customRate >= 0) {
            $this->selectedRate = floatval($this->customRate);
        }
        $this->calculateVat();
    }

    public function setMode($mode)
    {
        $this->mode = $mode;
        $this->calculateVat();
    }

    public function calculate()
    {
        $this->calculateVat();
        $this->showResults = true;

        // Save to history
        if ($this->total > 0 && !$this->error_message) {
            $countryData = collect($this->countries)->firstWhere('slug', $this->selectedCountrySlug);
            $entry = [
                'country' => $countryData['name'] ?? '',
                'flag_iso' => $countryData['iso'] ?? '',
                'amount' => $this->amount,
                'rate' => $this->selectedRate,
                'mode' => $this->mode,
                'net' => $this->net_amount,
                'vat' => $this->vat_amount,
                'total' => $this->total,
                'currency' => $this->selectedCountryObject?->currency_display ?? '€',
                'timestamp' => now()->timestamp,
            ];

            array_unshift($this->history, $entry);
            $this->history = array_slice($this->history, 0, 10);
            session()->put('hero_calc_history', $this->history);
        }
    }

    public function clearHistory()
    {
        $this->history = [];
        session()->forget('hero_calc_history');
    }

    public function loadFromHistory($index)
    {
        if (isset($this->history[$index])) {
            $entry = $this->history[$index];
            $countryData = collect($this->countries)->firstWhere('name', $entry['country']);
            if ($countryData) {
                $this->selectedCountrySlug = $countryData['slug'];
                $this->loadCountry();
            }
            $this->amount = $entry['amount'];
            $this->mode = $entry['mode'];
            $this->selectedRate = $entry['rate'];
            $this->calculateVat();
            $this->showResults = true;
        }
    }

    private function calculateVat()
    {
        $this->error_message = null;
        $this->showResults = true;

        try {
            if (is_numeric($this->amount)) {
                $amount = round(floatval($this->amount), 2);
            } else {
                $cleaned = str_replace(['.', ','], ['', '.'], $this->amount);
                $cleaned = preg_replace('/[^0-9.]/', '', $cleaned);
                $amount = round(floatval($cleaned), 2);
            }

            if (!is_numeric($amount) || $amount < 0) {
                throw new \InvalidArgumentException('Please enter a valid positive number');
            }

            $rate = floatval($this->selectedRate);

            if ($this->mode === 'include') {
                // Amount includes VAT - extract it
                $this->net_amount = round($amount / (1 + ($rate / 100)), 2);
                $this->vat_amount = round($amount - $this->net_amount, 2);
                $this->total = round($amount, 2);
            } else {
                // Amount excludes VAT - add it
                $this->net_amount = round($amount, 2);
                $this->vat_amount = round($amount * ($rate / 100), 2);
                $this->total = round($amount + $this->vat_amount, 2);
            }
        } catch (\Exception $e) {
            $this->error_message = $e->getMessage();
            $this->net_amount = 0;
            $this->vat_amount = 0;
            $this->total = 0;
        }
    }

    private function loadRates()
    {
        $this->rates = [];

        if (!$this->selectedCountryObject) {
            return;
        }

        $date = now()->format('Y-m-d');
        $historicalRates = VatRate::where('country_id', $this->selectedCountryObject->id)
            ->where('effective_from', '<=', $date)
            ->where(function ($query) use ($date) {
                $query->where('effective_to', '>=', $date)
                    ->orWhereNull('effective_to');
            })
            ->get();

        $addedTypes = [];

        if ($historicalRates->isNotEmpty()) {
            foreach ($historicalRates as $rate) {
                $type = strtolower($rate->type);
                if (!in_array($type, $addedTypes)) {
                    $this->rates[] = [
                        'name' => ucfirst(str_replace('_', ' ', $rate->type)),
                        'value' => $rate->rate,
                        'type' => $type,
                    ];
                    $addedTypes[] = $type;
                }
            }
        }

        // Fallback to country model rates
        if (empty($this->rates) || !in_array('standard', $addedTypes)) {
            if ($this->selectedCountryObject->standard_rate && !in_array('standard', $addedTypes)) {
                array_unshift($this->rates, [
                    'name' => 'Standard',
                    'value' => $this->selectedCountryObject->standard_rate,
                    'type' => 'standard',
                ]);
            }
        }

        if ($this->selectedCountryObject->reduced_rate && !in_array('reduced', $addedTypes)) {
            $this->rates[] = [
                'name' => 'Reduced',
                'value' => $this->selectedCountryObject->reduced_rate,
                'type' => 'reduced',
            ];
        }

        if ($this->selectedCountryObject->super_reduced_rate && !in_array('super_reduced', $addedTypes)) {
            $this->rates[] = [
                'name' => 'Super reduced',
                'value' => $this->selectedCountryObject->super_reduced_rate,
                'type' => 'super_reduced',
            ];
        }

        if ($this->selectedCountryObject->parking_rate && !in_array('parking', $addedTypes)) {
            $this->rates[] = [
                'name' => 'Parking',
                'value' => $this->selectedCountryObject->parking_rate,
                'type' => 'parking',
            ];
        }
    }

    public function render()
    {
        return view('livewire.hero-calculator');
    }
}
