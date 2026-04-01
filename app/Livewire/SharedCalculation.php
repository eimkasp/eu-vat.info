<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\VatRate;
use Livewire\Component;

class SharedCalculation extends Component
{
    public $country = '';

    public $amount = 100;

    public $rate = 0;

    public $mode = 'exclude';

    public $countryObject = null;

    public $countryRates = [];

    public $net_amount = 0;

    public $vat_amount = 0;

    public $total = 0;

    public $error_message = null;

    public $rateName = '';

    public function mount(string $country, string $amount = '100', string $rate = '0', string $mode = 'exclude')
    {
        $this->country = $country;
        $this->amount = $amount;
        $this->rate = $rate;
        $this->mode = in_array($mode, ['include', 'exclude']) ? $mode : 'exclude';

        $this->countryObject = Country::where('slug', $this->country)->first();

        if (!$this->countryObject) {
            abort(404);
        }

        $this->loadRates();
        $this->detectRateName();
        $this->calculate();
    }

    public function getShareUrlProperty(): string
    {
        return url(locale_path('/vat-calculation/' . $this->country . '/' . $this->amount . '/' . $this->rate . '/' . $this->mode));
    }

    public static function calculationUrl(string $country, $amount, $rate, string $mode): string
    {
        return locale_path('/vat-calculation/' . $country . '/' . $amount . '/' . $rate . '/' . $mode);
    }

    private function calculate()
    {
        $this->error_message = null;

        try {
            $amount = is_numeric($this->amount) ? round(floatval($this->amount), 2) : 0;

            if ($amount < 0) {
                throw new \InvalidArgumentException('Amount must be a positive number.');
            }

            $rate = floatval($this->rate);

            if ($this->mode === 'include') {
                $this->net_amount = round($amount / (1 + ($rate / 100)), 2);
                $this->vat_amount = round($amount - $this->net_amount, 2);
                $this->total = round($amount, 2);
            } else {
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
        $this->countryRates = [];

        if (!$this->countryObject) {
            return;
        }

        $date = now()->format('Y-m-d');
        $historicalRates = VatRate::where('country_id', $this->countryObject->id)
            ->where('effective_from', '<=', $date)
            ->where(function ($query) use ($date) {
                $query->where('effective_to', '>=', $date)
                    ->orWhereNull('effective_to');
            })
            ->get();

        $addedTypes = [];

        if ($historicalRates->isNotEmpty()) {
            foreach ($historicalRates as $r) {
                $type = strtolower($r->type);
                if (!in_array($type, $addedTypes)) {
                    $this->countryRates[] = [
                        'name' => ucfirst(str_replace('_', ' ', $r->type)),
                        'value' => $r->rate,
                        'type' => $type,
                    ];
                    $addedTypes[] = $type;
                }
            }
        }

        if (empty($this->countryRates) || !in_array('standard', $addedTypes)) {
            if ($this->countryObject->standard_rate && !in_array('standard', $addedTypes)) {
                array_unshift($this->countryRates, [
                    'name' => 'Standard',
                    'value' => $this->countryObject->standard_rate,
                    'type' => 'standard',
                ]);
            }
        }

        if ($this->countryObject->reduced_rate && !in_array('reduced', $addedTypes)) {
            $this->countryRates[] = [
                'name' => 'Reduced',
                'value' => $this->countryObject->reduced_rate,
                'type' => 'reduced',
            ];
        }

        if ($this->countryObject->super_reduced_rate && !in_array('super_reduced', $addedTypes)) {
            $this->countryRates[] = [
                'name' => 'Super reduced',
                'value' => $this->countryObject->super_reduced_rate,
                'type' => 'super_reduced',
            ];
        }

        if ($this->countryObject->parking_rate && !in_array('parking', $addedTypes)) {
            $this->countryRates[] = [
                'name' => 'Parking',
                'value' => $this->countryObject->parking_rate,
                'type' => 'parking',
            ];
        }
    }

    private function detectRateName()
    {
        $this->rateName = 'Custom';
        foreach ($this->countryRates as $r) {
            if (abs($r['value'] - $this->rate) < 0.01) {
                $this->rateName = $r['name'];
                break;
            }
        }
    }

    public function render()
    {
        return view('livewire.shared-calculation');
    }
}
