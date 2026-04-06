<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\VatValidationLog;
use App\Services\ViesValidationService;
use Livewire\Component;

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
            $service = app(ViesValidationService::class);
            $data = $service->validate($this->countryCode, $this->vatNumber);

            if (isset($data['error'])) {
                $this->error = $data['error'];
                return;
            }

            $this->result = [
                'valid' => $data['valid'] ?? false,
                'name' => $data['name'] ?? 'N/A',
                'address' => $data['address'] ?? 'N/A',
                'requestIdentifier' => $data['request_identifier'] ?? null,
                'source' => $data['source'] ?? 'unknown',
            ];

            // Log the validation
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

            $this->validationCount = VatValidationLog::where('vat_number', $this->vatNumber)
                ->where('country_code', $this->countryCode)
                ->count();

        } catch (\Exception $e) {
            $this->error = 'Error connecting to VIES service: '.$e->getMessage();
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
