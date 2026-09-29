<?php

namespace App\Livewire;

use App\Models\Country;
use App\Traits\TracksCountryViews;
use Livewire\Attributes\Locked;
use Livewire\Component;

class VatCalculator extends Component
{
    use TracksCountryViews;

    #[Locked]
    public ?string $slug = null;

    /** @var array{amount: ?string, rate: ?string, mode: ?string} */
    #[Locked]
    public array $prefill = ['amount' => null, 'rate' => null, 'mode' => null];

    public function mount(?string $slug = null): void
    {
        $this->prefill = [
            'amount' => is_string($amount = request()->query('amount')) && is_numeric($amount) ? $amount : null,
            'rate' => is_string($rate = request()->query('rate')) && is_numeric($rate) ? $rate : null,
            'mode' => in_array($mode = request()->query('mode'), ['include', 'exclude'], true) ? $mode : null,
        ];

        if ($slug === null) {
            return;
        }

        $country = Country::calculatorAvailable()->where('slug', $slug)->first();

        abort_unless($country, 404);

        $this->slug = $country->slug;
        $this->trackCountryView($country, 'calculator-view');
    }

    public function render()
    {
        $country = $this->slug ? Country::calculatorAvailable()->where('slug', $this->slug)->first() : null;

        return view('livewire.vat-calculator', [
            'country' => $country,
            'isCountryPage' => $country !== null,
        ]);
    }
}
