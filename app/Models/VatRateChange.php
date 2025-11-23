<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VatRateChange extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'vat_rate_id',
        'rate_type',
        'old_rate',
        'new_rate',
        'change_date',
        'announced_date',
        'change_reason',
        'description',
        'source',
        'source_url',
        'official_document',
        'percentage_change',
        'change_direction',
        'notification_sent',
        'notification_sent_at',
    ];

    protected $casts = [
        'change_date' => 'date',
        'announced_date' => 'date',
        'old_rate' => 'decimal:2',
        'new_rate' => 'decimal:2',
        'percentage_change' => 'decimal:2',
        'notification_sent' => 'boolean',
        'notification_sent_at' => 'datetime',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function vatRate()
    {
        return $this->belongsTo(VatRate::class);
    }

    /**
     * Calculate the percentage change
     */
    public function calculatePercentageChange(): float
    {
        if ($this->old_rate == 0) {
            return 0;
        }
        
        return round((($this->new_rate - $this->old_rate) / $this->old_rate) * 100, 2);
    }

    /**
     * Determine the change direction
     */
    public function determineChangeDirection(): string
    {
        if ($this->new_rate > $this->old_rate) {
            return 'increase';
        } elseif ($this->new_rate < $this->old_rate) {
            return 'decrease';
        }
        return 'no_change';
    }

    /**
     * Scope to get recent changes
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('change_date', '>=', now()->subDays($days));
    }

    /**
     * Scope to get upcoming changes
     */
    public function scopeUpcoming($query)
    {
        return $query->where('change_date', '>', now());
    }
}
