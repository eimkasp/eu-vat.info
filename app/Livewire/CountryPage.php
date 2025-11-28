<?php

namespace App\Livewire;

use App\Models\Country;
use Livewire\Component;
use App\Traits\TracksCountryViews;

class CountryPage extends Component
{
    use TracksCountryViews;
    
    public Country $country;
    public string $activeTab = 'overview';

    public function mount($slug, $tab = 'overview')
    {
        $this->country = Country::where('slug', $slug)->firstOrFail();
        $this->activeTab = $tab;
        $this->trackCountryView($this->country, 'country-view');
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        
        // Update the URL without page reload
        $url = $this->getTabUrl($tab);
        $this->dispatch('update-url', ['url' => $url]);
    }

    public function getTabUrl($tab)
    {
        if ($tab === 'overview') {
            return route('country.show', $this->country->slug);
        }
        
        return route('country.tab', ['slug' => $this->country->slug, 'tab' => $tab]);
    }

    public function getTabs()
    {
        return [
            'overview' => [
                'name' => 'Overview',
                'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'url' => route('country.show', $this->country->slug),
                'title' => "VAT Rates in {$this->country->name} - Overview",
                'description' => "Complete guide to VAT rates in {$this->country->name}. Standard rate: {$this->country->standard_rate}%. Learn about VAT compliance and regulations.",
            ],
            'vat-calculator' => [
                'name' => 'VAT Calculator',
                'icon' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z',
                'url' => route('country.tab', ['slug' => $this->country->slug, 'tab' => 'vat-calculator']),
                'title' => "VAT Calculator for {$this->country->name} - Calculate {$this->country->standard_rate}% VAT",
                'description' => "Free VAT calculator for {$this->country->name}. Calculate {$this->country->standard_rate}% VAT instantly. Add or remove VAT from any amount.",
            ],
            'vat-validator' => [
                'name' => 'VAT Number Validator',
                'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                'url' => route('country.tab', ['slug' => $this->country->slug, 'tab' => 'vat-validator']),
                'title' => "Validate {$this->country->name} VAT Numbers - VIES Verification",
                'description' => "Validate VAT numbers from {$this->country->name} using the official EU VIES system. Instant verification with company details.",
            ],
        ];
    }

    public function getCurrentTabMeta()
    {
        $tabs = $this->getTabs();
        return $tabs[$this->activeTab] ?? $tabs['overview'];
    }

    public function render()
    {
        return view('livewire.country', [
            'tabs' => $this->getTabs(),
            'tabMeta' => $this->getCurrentTabMeta(),
        ]);
    }
}
