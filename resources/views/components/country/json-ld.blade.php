@props(['country'])

<!-- Structured Data -->
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    'name' => $country->name . ' VAT Rates & Calculator',
    'description' => 'Complete VAT guide for ' . $country->name . '. Standard rate: ' . $country->standard_rate . '%. Free VAT calculator, all rates, compliance info.',
    'url' => route('country.show', $country->slug),
    'breadcrumb' => [
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => $country->name, 'item' => route('country.show', $country->slug)],
        ],
    ],
    'mainEntity' => [
        '@type' => 'GovernmentService',
        'name' => $country->name . ' VAT Information',
        'description' => 'VAT rates and tools for ' . $country->name,
        'provider' => ['@type' => 'GovernmentOrganization', 'name' => $country->name . ' Tax Authority'],
        'areaServed' => ['@type' => 'Country', 'name' => $country->name],
        'serviceOutput' => ['@type' => 'TaxRate', 'name' => 'Standard VAT Rate', 'value' => (string) $country->standard_rate, 'unitText' => 'PERCENT'],
    ],
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>

<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'SoftwareApplication',
    'name' => $country->name . ' VAT Calculator',
    'applicationCategory' => 'FinanceApplication',
    'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'EUR'],
    'description' => 'Free online VAT calculator for ' . $country->name . '. Calculate ' . $country->standard_rate . '% VAT instantly.',
    'operatingSystem' => 'Web Browser',
    'url' => route('country.show', $country->slug),
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
