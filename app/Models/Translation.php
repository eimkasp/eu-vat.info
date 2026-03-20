<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $fillable = [
        'key',
        'locale',
        'value',
        'group',
    ];

    public static function get($key, $locale = null, $group = null)
    {
        $locale = $locale ?? app()->getLocale();

        $translation = static::where('key', $key)
            ->where('locale', $locale)
            ->when($group, fn ($q) => $q->where('group', $group))
            ->first();

        return $translation?->value;
    }
}
