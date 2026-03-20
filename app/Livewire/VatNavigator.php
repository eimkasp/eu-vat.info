<?php

namespace App\Livewire;

use App\Models\Country;
use Livewire\Component;

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
        $this->countries = Country::orderBy('name')->get()->map(function ($c) {
            return ['id' => $c->id, 'name' => $c->name];
        })->toArray();
    }

    public function updated($property)
    {
        $this->calculate();
    }

    public function calculate()
    {
        if (! $this->sellerCountry || ! $this->buyerCountry) {
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
                'action' => __('ui.navigator.result_export_action'),
                'rate' => 0,
                'explanation' => __('ui.navigator.result_export_explanation'),
            ];

            return;
        }

        if ($isDomestic) {
            $this->result = [
                'action' => __('ui.navigator.result_domestic_action'),
                'rate' => $seller->standard_rate,
                'explanation' => __('ui.navigator.result_domestic_explanation', ['country' => $seller->name]),
            ];

            return;
        }

        // Intra-EU
        if ($this->buyerType === 'b2b') {
            if ($this->productCategory === 'construction') {
                $this->result = [
                    'action' => __('ui.navigator.result_b2b_construction_action'),
                    'rate' => 0,
                    'explanation' => __('ui.navigator.result_b2b_construction_explanation'),
                ];
            } elseif ($this->productCategory === 'events') {
                $this->result = [
                    'action' => __('ui.navigator.result_b2b_events_action'),
                    'rate' => 'Local Rate',
                    'explanation' => __('ui.navigator.result_b2b_events_explanation'),
                ];
            } else {
                // General B2B
                $this->result = [
                    'action' => __('ui.navigator.result_b2b_general_action'),
                    'rate' => 0,
                    'explanation' => __('ui.navigator.result_b2b_general_explanation'),
                ];
            }
        } else {
            // B2C
            if ($this->itemType === 'goods') {
                $this->result = [
                    'action' => __('ui.navigator.result_b2c_goods_action'),
                    'rate' => $buyer->standard_rate,
                    'explanation' => __('ui.navigator.result_b2c_goods_explanation', ['country' => $buyer->name]),
                ];
            } else {
                // Services
                if ($this->productCategory === 'digital') {
                    $this->result = [
                        'action' => __('ui.navigator.result_b2c_digital_action'),
                        'rate' => $buyer->standard_rate,
                        'explanation' => __('ui.navigator.result_b2c_digital_explanation', ['country' => $buyer->name]),
                    ];
                } elseif ($this->productCategory === 'events') {
                    $this->result = [
                        'action' => __('ui.navigator.result_b2c_events_action'),
                        'rate' => 'Local Rate',
                        'explanation' => __('ui.navigator.result_b2c_events_explanation'),
                    ];
                } else {
                    $this->result = [
                        'action' => __('ui.navigator.result_b2c_services_action'),
                        'rate' => $seller->standard_rate,
                        'explanation' => __('ui.navigator.result_b2c_services_explanation', ['country' => $seller->name]),
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
