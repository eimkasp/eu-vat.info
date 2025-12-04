<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VatRate extends Model
{
    protected $fillable = [
        'country_id',
        'type',
        'rate',
        'effective_from',
        'effective_to',
        'source',
    ];

    protected $casts = [
        'effective_from' => 'date',
        'effective_to' => 'date',
        'rate' => 'decimal:2',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
