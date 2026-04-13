<?php

namespace App\Livewire;

use Livewire\Component;

class ChromeExtension extends Component
{
    public string $storeUrl = 'https://chromewebstore.google.com/detail/eu-vat-calculator/fifmbbpgopnifnoginhmjjedjnabdkka';

    public function render()
    {
        return view('livewire.chrome-extension');
    }
}
