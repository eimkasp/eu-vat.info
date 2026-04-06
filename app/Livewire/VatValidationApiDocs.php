<?php

namespace App\Livewire;

use Livewire\Component;

class VatValidationApiDocs extends Component
{
    public string $baseUrl;

    public function mount(): void
    {
        $this->baseUrl = rtrim(config('app.url'), '/');
    }

    public function render()
    {
        return view('livewire.vat-validation-api-docs');
    }
}
