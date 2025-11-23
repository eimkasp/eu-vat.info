<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Country;

class VatNavigator extends Component
{
    public $sellerCountry;
    public $buyerCountry;
    public $buyerType = 'b2c'; // b2b, b2c
    public $itemType = 'goods'; // goods, services
    public $productCategory = 'general'; // general, digital, construction, events
    public $result = null;
    public $countries = [];

    public function mount()
    {
        $this->countries = Country::orderBy('name')->get()->map(function($c) {
            return ['id' => $c->id, 'name' => $c->name];
        })->toArray();
    }

    public function updated($property)
    {
        $this->calculate();
    }

    public function calculate()
    {
        if (!$this->sellerCountry || !$this->buyerCountry) {
            $this->result = null;
            return;
        }

        $isDomestic = $this->sellerCountry === $this->buyerCountry;
        $isBuyerEU = collect($this->countries)->where('id', $this->buyerCountry)->isNotEmpty();
        // Wait, I need "Non-EU" option.
        // I'll handle "other" as ID 0 or 'non-eu'.
        
        // Let's assume the list is EU countries. If buyerCountry is 'non-eu', then export.
        
        $seller = Country::find($this->sellerCountry);
        $buyer = $this->buyerCountry === 'non-eu' ? null : Country::find($this->buyerCountry);

        if ($this->buyerCountry === 'non-eu') {
            // Export
            $this->result = [
                'action' => 'Zero-Rated (Export)',
                'rate' => 0,
                'explanation' => 'Sales to countries outside the EU are generally zero-rated for VAT (exempt with credit). You must retain proof of export.',
            ];
            return;
        }

        if ($isDomestic) {
            $this->result = [
                'action' => 'Charge Domestic VAT',
                'rate' => $seller->standard_rate,
                'explanation' => "Since both buyer and seller are in {$seller->name}, you must charge the standard domestic VAT rate.",
            ];
            return;
        }

        // Intra-EU
        if ($this->buyerType === 'b2b') {
            if ($this->productCategory === 'construction') {
                 $this->result = [
                    'action' => 'Reverse Charge (0% VAT)',
                    'rate' => 0,
                    'explanation' => "For construction services, the Reverse Charge mechanism usually applies in B2B transactions. The recipient accounts for the VAT.",
                ];
            } elseif ($this->productCategory === 'events') {
                 $this->result = [
                    'action' => 'Place of Event Rule',
                    'rate' => 'Local Rate',
                    'explanation' => "Admission to events is taxable where the event actually takes place. If the event is in the buyer's country, you may need to register for VAT there or check specific exceptions.",
                ];
            } else {
                // General B2B
                $this->result = [
                    'action' => 'Reverse Charge (0% VAT)',
                    'rate' => 0,
                    'explanation' => "For B2B transactions between EU countries, the Reverse Charge mechanism typically applies. The buyer accounts for the VAT. Do not charge VAT but verify their VAT number.",
                ];
            }
        } else {
            // B2C
            if ($this->itemType === 'goods') {
                $this->result = [
                    'action' => 'Charge Destination VAT (OSS)',
                    'rate' => $buyer->standard_rate,
                    'explanation' => "For B2C distance sales of goods (>€10k EU-wide threshold), charge VAT at the rate of the buyer's country ({$buyer->name}). Use OSS to report.",
                ];
            } else {
                // Services
                if ($this->productCategory === 'digital') {
                    $this->result = [
                        'action' => 'Charge Destination VAT (OSS)',
                        'rate' => $buyer->standard_rate,
                        'explanation' => "For digital services (TBE services) to consumers, you must charge VAT at the rate of the customer's country ({$buyer->name}). Use OSS to simplify reporting.",
                    ];
                } elseif ($this->productCategory === 'events') {
                    $this->result = [
                        'action' => 'Place of Event',
                        'rate' => 'Local Rate',
                        'explanation' => "Admission to cultural, artistic, or educational events is taxable where the event takes place.",
                    ];
                } else {
                    $this->result = [
                        'action' => 'Charge Domestic VAT',
                        'rate' => $seller->standard_rate,
                        'explanation' => "For general services to consumers (consulting, etc.), the general rule is to charge VAT of the supplier's country ({$seller->name}).",
                    ];
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.vat-navigator');
    }
}
