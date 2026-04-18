<?php

namespace App\Livewire;

use Livewire\Component;

class Donate extends Component
{
    public string $apiBaseUrl;

    public bool $x402Enabled;

    public string $x402Network;

    public array $x402Routes;

    public function mount()
    {
        $this->apiBaseUrl = url('/api');
        $this->x402Enabled = (bool) config('x402.enabled', false);
        $this->x402Network = config('x402.network', 'eip155:84532');
        $this->x402Routes = config('x402.routes', []);
    }

    public function render()
    {
        return view('livewire.donate');
    }
}
