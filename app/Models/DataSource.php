<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class DataSource extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'url',
        'api_endpoint',
        'type',
        'credibility_score',
        'reliability_score',
        'last_checked_at',
        'last_successful_update',
        'consecutive_failures',
        'is_active',
        'is_primary',
        'priority',
        'requests_per_day',
        'requests_today',
        'requests_reset_date',
    ];

    protected $casts = [
        'last_checked_at' => 'datetime',
        'last_successful_update' => 'datetime',
        'requests_reset_date' => 'date',
        'is_active' => 'boolean',
        'is_primary' => 'boolean',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Check if source can be queried (rate limiting)
     */
    public function canQuery(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if (!$this->requests_per_day) {
            return true;
        }

        // Reset counter if it's a new day
        if ($this->requests_reset_date && $this->requests_reset_date->isToday()) {
            return $this->requests_today < $this->requests_per_day;
        }

        return true;
    }

    /**
     * Increment request counter
     */
    public function incrementRequests(): void
    {
        if (!$this->requests_reset_date || !$this->requests_reset_date->isToday()) {
            $this->update([
                'requests_today' => 1,
                'requests_reset_date' => now()->toDateString(),
            ]);
        } else {
            $this->increment('requests_today');
        }
    }

    /**
     * Record successful update
     */
    public function recordSuccess(): void
    {
        $this->update([
            'last_successful_update' => now(),
            'consecutive_failures' => 0,
            'last_checked_at' => now(),
        ]);
    }

    /**
     * Record failed update
     */
    public function recordFailure(): void
    {
        $this->increment('consecutive_failures');
        $this->update(['last_checked_at' => now()]);

        // Deactivate after too many failures
        if ($this->consecutive_failures >= 5) {
            $this->update(['is_active' => false]);
        }
    }

    /**
     * Scope for active sources
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for sources ordered by priority
     */
    public function scopeByPriority($query)
    {
        return $query->orderBy('priority', 'desc')
                    ->orderBy('credibility_score', 'desc');
    }
}
