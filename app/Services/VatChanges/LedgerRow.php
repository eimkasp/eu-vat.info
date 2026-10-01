<?php

namespace App\Services\VatChanges;

use Carbon\CarbonImmutable;

final readonly class LedgerRow
{
    public function __construct(
        public int $line,
        public string $country,
        public string $rateType,
        public float $oldRate,
        public float $newRate,
        public CarbonImmutable $effectiveDate,
        public ?CarbonImmutable $announcedDate,
        public string $status,
        public ?string $reason,
        public string $description,
        public string $source,
        public string $sourceUrl,
        public ?string $officialDocument,
    ) {}

    public function isEnacted(): bool
    {
        return $this->status === LedgerReader::ENACTED;
    }

    public function key(): string
    {
        return implode('|', [$this->country, $this->rateType, $this->effectiveDate->toDateString()]);
    }
}
