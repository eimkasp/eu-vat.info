<?php

namespace App\Services\VatChanges;

final class ImportReport
{
    public int $created = 0;

    public int $updated = 0;

    public int $unchanged = 0;

    /** @var list<LedgerRow> */
    public array $watchlist = [];

    /** @var list<string> */
    public array $skipped = [];

    public function written(): int
    {
        return $this->created + $this->updated;
    }
}
