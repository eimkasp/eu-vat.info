<?php

namespace App\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class TopCalculationsAmount extends Component
{
    #[Locked]
    public int $amount;

    public function mount(int $amount): void
    {
        abort_unless(in_array($amount, TopCalculations::AMOUNTS, true), 404);

        $this->amount = $amount;
    }

    /**
     * @return list<array{name: string, slug: string, iso_code: string, standard_rate: float}>
     */
    #[Computed]
    public function countries(): array
    {
        return TopCalculations::euCountries();
    }

    public function render()
    {
        return view('livewire.top-calculations-amount', ['amounts' => TopCalculations::AMOUNTS]);
    }
}
