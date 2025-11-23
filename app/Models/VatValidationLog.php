<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VatValidationLog extends Model
{
    protected $fillable = [
        'country_code',
        'vat_number',
        'is_valid',
        'name',
        'address',
        'request_identifier',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'is_valid' => 'boolean',
    ];
}
