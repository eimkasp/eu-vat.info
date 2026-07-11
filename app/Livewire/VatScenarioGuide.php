<?php

namespace App\Livewire;

use Livewire\Component;

class VatScenarioGuide extends Component
{
    public string $scenario;

    public array $guide;

    public function mount(string $scenario): void
    {
        $guide = config('vat-scenarios.'.$scenario);
        abort_unless(is_array($guide), 404);

        $this->scenario = $scenario;
        $this->guide = $guide;
    }

    public function render()
    {
        return view('livewire.vat-scenario-guide');
    }
}
