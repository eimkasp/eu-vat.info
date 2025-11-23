<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Models\VatValidationLog;
use App\Models\Country;

class VatValidator extends Component
{
    public $countryCode;
    public $vatNumber;
    public $result = null;
    public $error = null;
    public $countries;
    public $validationCount = 0;

    public function mount($country = null, $slug = null)
    {
        $this->countries = Country::orderBy('name')->get();
        
        if ($country) {
            $this->countryCode = $country->iso_code;
        } elseif ($slug) {
            $found = Country::where('slug', $slug)->first();
            if ($found) {
                $this->countryCode = $found->iso_code;
            }
        }
    }

    public function validateVat()
    {
        $this->validate([
            'countryCode' => 'required|string|size:2',
            'vatNumber' => 'required|string|min:5',
        ]);

        $this->result = null;
        $this->error = null;

        try {
            // VIES REST API
            // POST https://ec.europa.eu/taxation_customs/vies/rest-api/check-vat-number
            $response = Http::post('https://ec.europa.eu/taxation_customs/vies/rest-api/check-vat-number', [
                'countryCode' => $this->countryCode,
                'vatNumber' => $this->vatNumber,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                $this->result = [
                    'valid' => $data['valid'] ?? false,
                    'name' => $data['name'] ?? 'N/A',
                    'address' => $data['address'] ?? 'N/A',
                    'requestIdentifier' => $data['requestIdentifier'] ?? null,
                ];

                // Log
                VatValidationLog::create([
                    'country_code' => $this->countryCode,
                    'vat_number' => $this->vatNumber,
                    'is_valid' => $this->result['valid'],
                    'name' => $this->result['name'],
                    'address' => $this->result['address'],
                    'request_identifier' => $this->result['requestIdentifier'],
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);

                // Count how many times checked
                $this->validationCount = VatValidationLog::where('vat_number', $this->vatNumber)
                    ->where('country_code', $this->countryCode)
                    ->count();

            } else {
                $this->error = 'Validation service unavailable or invalid input. ' . ($response->json()['errorWrapper']['error'] ?? '');
            }

        } catch (\Exception $e) {
            $this->error = 'Error connecting to VIES service: ' . $e->getMessage();
        }
    }

    public function prefillExample()
    {
        $this->countryCode = 'LT';
        $this->vatNumber = '100019070512';
        $this->validateVat();
    }

    public function render()
    {
        return view('livewire.vat-validator');
    }
}
