<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VatHistory extends Model
{
    use HasFactory;

    protected $table = 'vat_history';
    protected $fillable = [
        'country_id',
        'vat_rate',
        'year',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
