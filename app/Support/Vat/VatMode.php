<?php

namespace App\Support\Vat;

enum VatMode: string
{
    case Exclude = 'exclude';
    case Include = 'include';

    public static function fromInput(mixed $value): self
    {
        return match (strtolower(trim((string) $value))) {
            'include', 'remove', 'gross', 'incl' => self::Include,
            default => self::Exclude,
        };
    }
}
