<?php

namespace App\Http\Resources;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->iso_code,
            'slug' => $this->slug,
            'rates' => [
                'standard' => $this->standard_rate,
                'reduced' => $this->primaryReducedRate() === null ? null : Country::formatRate($this->primaryReducedRate()),
                'reduced_rates' => $this->reducedRates(),
                'super_reduced' => $this->super_reduced_rate,
                'zero' => $this->zero_rate,
            ],
            'links' => [
                'calculator' => route('vat-calculator.country', $this->slug),
                'details' => route('vat-calculator.country', $this->slug),
            ],
            'last_updated' => $this->updated_at->toISOString(),
        ];
    }
}
