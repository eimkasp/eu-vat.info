<?php

namespace App\Livewire;

use App\Services\ViesValidationService;
use Livewire\Component;

class VatValidationWidget extends Component
{
    public string $countryCode = '';
    public string $vatNumber = '';
    public ?array $validationResult = null;
    public bool $isLoading = false;
    public ?string $errorMessage = null;

    protected $rules = [
        'countryCode' => 'required|string|size:2',
        'vatNumber' => 'required|string|min:2|max:20',
    ];

    protected $messages = [
        'countryCode.required' => 'Please select a country',
        'countryCode.size' => 'Country code must be 2 characters',
        'vatNumber.required' => 'VAT number is required',
        'vatNumber.min' => 'VAT number is too short',
        'vatNumber.max' => 'VAT number is too long',
    ];

    public function mount(?string $countryCode = null)
    {
        $this->countryCode = strtoupper($countryCode ?? '');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        
        // Clear previous results when inputs change
        $this->validationResult = null;
        $this->errorMessage = null;
    }

    public function validate()
    {
        $this->isLoading = true;
        $this->errorMessage = null;
        $this->validationResult = null;

        try {
            $this->validate();

            $service = app(ViesValidationService::class);
            $result = $service->validate(
                strtoupper($this->countryCode),
                $this->vatNumber
            );

            $this->validationResult = $result;

            // Dispatch browser event for animations
            $this->dispatch('validation-complete', [
                'valid' => $result['valid'],
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->errorMessage = collect($e->errors())->flatten()->first();
        } catch (\Exception $e) {
            $this->errorMessage = 'Validation service temporarily unavailable. Please try again.';
            \Log::error('VAT validation error', [
                'country' => $this->countryCode,
                'vat' => $this->vatNumber,
                'error' => $e->getMessage(),
            ]);
        } finally {
            $this->isLoading = false;
        }
    }

    public function clear()
    {
        $this->reset(['vatNumber', 'validationResult', 'errorMessage']);
        
        if (empty($this->countryCode)) {
            $this->countryCode = '';
        }
    }

    public function render()
    {
        $euCountries = [
            'AT' => 'Austria',
            'BE' => 'Belgium',
            'BG' => 'Bulgaria',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DE' => 'Germany',
            'DK' => 'Denmark',
            'EE' => 'Estonia',
            'EL' => 'Greece',
            'ES' => 'Spain',
            'FI' => 'Finland',
            'FR' => 'France',
            'HR' => 'Croatia',
            'HU' => 'Hungary',
            'IE' => 'Ireland',
            'IT' => 'Italy',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'LV' => 'Latvia',
            'MT' => 'Malta',
            'NL' => 'Netherlands',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'RO' => 'Romania',
            'SE' => 'Sweden',
            'SI' => 'Slovenia',
            'SK' => 'Slovakia',
        ];

        return view('livewire.vat-validation-widget', [
            'euCountries' => $euCountries,
        ]);
    }
}
