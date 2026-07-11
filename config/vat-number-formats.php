<?php

$sourceUrl = 'https://taxation-customs.ec.europa.eu/taxation/vat/vat-directive/vat-identification-numbers_en';
$memberCodes = [
    'AT', 'BE', 'BG', 'HR', 'CY', 'CZ', 'DK', 'EE', 'FI', 'FR', 'DE', 'GR',
    'HU', 'IE', 'IT', 'LV', 'LT', 'LU', 'MT', 'NL', 'PL', 'PT', 'RO', 'SK',
    'SI', 'ES', 'SE',
];

$formats = [];

foreach ($memberCodes as $code) {
    $prefix = $code === 'GR' ? 'EL' : $code;
    $formats[$code] = [
        'prefix' => $prefix,
        'guidance' => $prefix.' + national identifier',
        'note' => $code === 'GR'
            ? 'Greece uses EL for VAT identification numbers, while GR remains the ISO country code.'
            : 'The national identifier may contain a country-specific sequence of digits or characters.',
        'source_url' => $sourceUrl,
    ];
}

return $formats;
