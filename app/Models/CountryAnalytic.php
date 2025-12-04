<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CountryAnalytic extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'type',
        'ip_address',
        'user_agent',
        'referer',
        'location_country',
        'location_city',
        'amount',
        'rate_used',
        'meta_data',
    ];

    protected $casts = [
        'meta_data' => 'array',
        'amount' => 'decimal:2',
        'rate_used' => 'decimal:2',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
