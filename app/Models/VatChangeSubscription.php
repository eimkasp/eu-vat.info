<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VatChangeSubscription extends Model
{
    public const STATUS_ACTIVE = 'active';

    public const STATUS_UNSUBSCRIBED = 'unsubscribed';

    protected $fillable = [
        'email',
        'status',
        'subscribed_at',
        'unsubscribed_at',
        'last_notified_at',
        'source',
        'locale',
        'ip_hash',
        'country_filters',
    ];

    protected function casts(): array
    {
        return [
            'subscribed_at' => 'datetime',
            'unsubscribed_at' => 'datetime',
            'last_notified_at' => 'datetime',
            'country_filters' => 'array',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function reactivate(string $source, string $locale, ?string $ipHash = null): void
    {
        $subscribedAt = $this->exists && $this->status === self::STATUS_ACTIVE && $this->subscribed_at
            ? $this->subscribed_at
            : now();

        $this->fill([
            'status' => self::STATUS_ACTIVE,
            'source' => $source,
            'locale' => $locale,
            'ip_hash' => $ipHash,
            'subscribed_at' => $subscribedAt,
            'unsubscribed_at' => null,
        ])->save();
    }

    public function unsubscribe(): void
    {
        $this->forceFill([
            'status' => self::STATUS_UNSUBSCRIBED,
            'unsubscribed_at' => now(),
        ])->save();
    }

    public static function normalizeEmail(string $email): string
    {
        return Str::lower(trim($email));
    }
}
