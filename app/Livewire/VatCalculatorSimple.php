<?php

namespace App\Livewire;

use App\Models\Country;
use Livewire\Component;

class VatCalculatorSimple extends Component
{
    public Country $country;
    public float $amount = 100;
    public string $mode = 'exclude'; // 'exclude' or 'include'
    public float $vatRate;
    public bool $useCustomRate = false;
    
    public function mount(Country $country)
    {
        $this->country = $country;
        $this->vatRate = $country->standard_rate;
    }

    public function setStandardRate()
    {
        $this->useCustomRate = false;
        $this->vatRate = $this->country->standard_rate;
    }

    public function setReducedRate()
    {
        if ($this->country->reduced_rate) {
            $this->useCustomRate = false;
            $this->vatRate = $this->country->reduced_rate;
        }
    }

    public function setSuperReducedRate()
    {
        if ($this->country->super_reduced_rate) {
            $this->useCustomRate = false;
            $this->vatRate = $this->country->super_reduced_rate;
        }
    }

    public function enableCustomRate()
    {
        $this->useCustomRate = true;
    }

    public function calculate()
    {
        // Calculation happens in the computed properties
        $this->dispatch('calculation-updated');
    }

    public function getNetAmountProperty()
    {
        if ($this->mode === 'exclude') {
            return $this->amount;
        }
        
        // Remove VAT from gross
        return $this->amount / (1 + $this->vatRate / 100);
    }

    public function getVatAmountProperty()
    {
        if ($this->mode === 'exclude') {
            return $this->amount * ($this->vatRate / 100);
        }
        
        return $this->amount - $this->netAmount;
    }

    public function getGrossAmountProperty()
    {
        if ($this->mode === 'exclude') {
            return $this->amount + $this->vatAmount;
        }
        
        return $this->amount;
    }

    public function updated($property)
    {
        if ($property === 'vatRate') {
            // Ensure VAT rate is within valid range
            $this->vatRate = max(0, min(100, $this->vatRate));
        }
        
        if ($property === 'amount') {
            $this->amount = max(0, $this->amount);
        }
    }

    public function render()
    {
        return view('livewire.vat-calculator-simple');
    }
}
