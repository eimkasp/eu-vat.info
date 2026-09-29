<?php

namespace App\Support\DesignSystem;

use InvalidArgumentException;

final class Color
{
    /**
     * @param  array<int, float>  $components  OKLCH lightness, chroma and hue, or sRGB channels from 0 to 1
     */
    private function __construct(
        public readonly string $css,
        public readonly string $space,
        public readonly array $components,
        public readonly float $alpha,
    ) {}

    public static function parse(string $css): self
    {
        $css = trim($css);

        if (preg_match('/^oklch\(\s*([\d.]+)(%?)\s+([\d.]+)\s+([\d.]+)(?:deg)?\s*(?:\/\s*([\d.]+)(%?))?\s*\)$/i', $css, $match)) {
            $lightness = (float) $match[1] / ($match[2] === '%' ? 100 : 1);
            $alpha = isset($match[5]) ? (float) $match[5] / (($match[6] ?? '') === '%' ? 100 : 1) : 1.0;

            return new self($css, 'oklch', [$lightness, (float) $match[3], (float) $match[4]], $alpha);
        }

        if (preg_match('/^#([0-9a-f]{3}|[0-9a-f]{6})$/i', $css, $match)) {
            $hex = strlen($match[1]) === 3 ? preg_replace('/(.)/', '$1$1', $match[1]) : $match[1];

            return new self($css, 'srgb', array_map(fn (string $pair) => hexdec($pair) / 255, str_split(strtolower($hex), 2)), 1.0);
        }

        throw new InvalidArgumentException("Unsupported colour value [{$css}].");
    }

    /**
     * Gamma-encoded sRGB channels from 0 to 1, clipped to the sRGB gamut.
     *
     * @return array<int, float>
     */
    public function rgb(): array
    {
        if ($this->space === 'srgb') {
            return $this->components;
        }

        [$lightness, $chroma, $hue] = $this->components;
        $a = $chroma * cos(deg2rad($hue));
        $b = $chroma * sin(deg2rad($hue));

        $l = ($lightness + 0.3963377774 * $a + 0.2158037573 * $b) ** 3;
        $m = ($lightness - 0.1055613458 * $a - 0.0638541728 * $b) ** 3;
        $s = ($lightness - 0.0894841775 * $a - 1.2914855480 * $b) ** 3;

        $linear = [
            4.0767416621 * $l - 3.3077115913 * $m + 0.2309699292 * $s,
            -1.2684380046 * $l + 2.6097574011 * $m - 0.3413193965 * $s,
            -0.0041960863 * $l - 0.7034186147 * $m + 1.7076147010 * $s,
        ];

        return array_map(function (float $channel) {
            $channel = max(0.0, min(1.0, $channel));

            return $channel <= 0.0031308 ? 12.92 * $channel : 1.055 * $channel ** (1 / 2.4) - 0.055;
        }, $linear);
    }

    public function hex(): string
    {
        return '#'.implode('', array_map(fn (float $channel) => str_pad(dechex((int) round($channel * 255)), 2, '0', STR_PAD_LEFT), $this->rgb()));
    }

    public function luminance(): float
    {
        [$r, $g, $b] = array_map(fn (float $channel) => $channel <= 0.04045 ? $channel / 12.92 : (($channel + 0.055) / 1.055) ** 2.4, $this->rgb());

        return 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;
    }

    public function contrast(self $other): float
    {
        $lighter = max($this->luminance(), $other->luminance());
        $darker = min($this->luminance(), $other->luminance());

        return ($lighter + 0.05) / ($darker + 0.05);
    }

    /**
     * The colour as a Design Tokens Community Group (2025.10) colour value.
     *
     * @return array{colorSpace: string, components: array<int, float>, alpha: float, hex: string}
     */
    public function toDtcg(): array
    {
        return [
            'colorSpace' => $this->space,
            'components' => array_map(fn (float $component) => round($component, 4), $this->components),
            'alpha' => $this->alpha,
            'hex' => $this->hex(),
        ];
    }
}
