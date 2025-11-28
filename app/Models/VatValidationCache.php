<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VatValidationCache extends Model
{
    protected $table = 'vat_validation_cache';

    protected $fillable = [
        'country_code',
        'vat_number',
        'is_valid',
        'name',
        'address',
        'last_checked_at',
    ];

    protected $casts = [
        'is_valid' => 'boolean',
        'last_checked_at' => 'datetime',
    ];

    /**
     * Get the full VAT number with country code
     */
    public function getFullVatNumberAttribute(): string
    {
        return $this->country_code . $this->vat_number;
    }

    /**
     * Check if cache is stale (older than 7 days)
     */
    public function isStale(): bool
    {
        return $this->last_checked_at->diffInDays(now()) > 7;
    }
}
