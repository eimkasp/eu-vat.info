<?php

namespace App\Support\Vat;

/**
 * Immutable VAT breakdown rounded to the cent (half-up on the decimal value), shared by the
 * calculators, the public API and the MCP server so every surface returns identical figures.
 */
final readonly class VatCalculation
{
    public const MAX_AMOUNT = 1_000_000_000_000;

    private function __construct(
        public float $net,
        public float $vat,
        public float $gross,
        public float $rate,
        public VatMode $mode,
    ) {}

    public static function make(float|int|string|null $amount, float|int|string|null $rate, VatMode|string $mode): self
    {
        $mode = $mode instanceof VatMode ? $mode : VatMode::fromInput($mode);
        $amount = min(max((float) $amount, 0.0), (float) self::MAX_AMOUNT);
        $rate = min(max((float) $rate, 0.0), 100.0);

        if ($mode === VatMode::Include) {
            $gross = round($amount, 2);
            $net = round($gross / (1 + $rate / 100), 2);

            return new self($net, round($gross - $net, 2), $gross, $rate, $mode);
        }

        $net = round($amount, 2);
        $vat = round($net * $rate / 100, 2);

        return new self($net, $vat, round($net + $vat, 2), $rate, $mode);
    }

    public static function addVat(float|int|string|null $net, float|int|string|null $rate): self
    {
        return self::make($net, $rate, VatMode::Exclude);
    }

    public static function removeVat(float|int|string|null $gross, float|int|string|null $rate): self
    {
        return self::make($gross, $rate, VatMode::Include);
    }

    /** The amount the user typed: net when adding VAT, gross when removing it. */
    public function input(): float
    {
        return $this->mode === VatMode::Include ? $this->gross : $this->net;
    }

    /** @return array{net: float, vat: float, gross: float, rate: float, mode: string} */
    public function toArray(): array
    {
        return [
            'net' => $this->net,
            'vat' => $this->vat,
            'gross' => $this->gross,
            'rate' => $this->rate,
            'mode' => $this->mode->value,
        ];
    }
}
