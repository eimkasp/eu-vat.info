<?php

$placeSource = 'https://taxation-customs.ec.europa.eu/taxation/vat/vat-directive/place-taxation_en';
$liabilitySource = 'https://taxation-customs.ec.europa.eu/taxation/vat/vat-directive/persons-liable-vat_en';
$ossSource = 'https://taxation-customs.ec.europa.eu/taxation/vat/vat-special-schemes/vat-special-schemes-oss_en';

return [
    'b2b-services' => [
        'title' => 'EU B2B services VAT guide',
        'summary' => 'The general EU rule for services supplied to a business customer is taxation where that customer is established.',
        'rule' => 'Article 44 of the VAT Directive generally places B2B services where the customer is established. When the supplier is not established there, Article 196 commonly makes the business customer liable through the reverse charge.',
        'exceptions' => 'Immovable property, events, transport, restaurant services and other specifically listed services can follow different place-of-supply rules.',
        'legal_refs' => ['Article 44', 'Article 196'],
        'sources' => [$placeSource, $liabilitySource],
    ],
    'b2c-services' => [
        'title' => 'EU B2C services VAT guide',
        'summary' => 'The general EU rule for services supplied to a private consumer is taxation where the supplier is established.',
        'rule' => 'Article 45 generally places B2C services where the supplier has established its business.',
        'exceptions' => 'Digital services, immovable property, events, transport and several other service categories have destination or performance-place rules.',
        'legal_refs' => ['Article 45'],
        'sources' => [$placeSource],
    ],
    'b2c-digital-services' => [
        'title' => 'EU B2C digital services VAT guide',
        'summary' => 'Telecommunications, broadcasting and electronically supplied B2C services are generally taxed where the customer resides.',
        'rule' => 'Article 58 applies destination taxation to these services. Article 59c provides a EUR 10,000 cross-border threshold for qualifying EU-established suppliers, unless they opt into destination taxation.',
        'exceptions' => 'The threshold and OSS eligibility depend on establishment, customer location evidence, transaction type and prior elections.',
        'legal_refs' => ['Article 58', 'Article 59c'],
        'sources' => [$placeSource, $ossSource],
    ],
    'b2c-distance-sales' => [
        'title' => 'EU B2C distance sales VAT guide',
        'summary' => 'Intra-EU distance sales of goods are generally taxed where transport to the consumer ends.',
        'rule' => 'Article 33 applies destination taxation. Article 59c provides a EUR 10,000 combined threshold for qualifying EU-established suppliers, while OSS can simplify reporting.',
        'exceptions' => 'Imports, excise goods, installation supplies, marketplaces and non-EU establishments can require different treatment.',
        'legal_refs' => ['Article 33', 'Article 59c'],
        'sources' => [$placeSource, $ossSource],
    ],
    'property-services' => [
        'title' => 'EU immovable property services VAT guide',
        'summary' => 'Services sufficiently connected with immovable property are generally taxed where the property is located.',
        'rule' => 'Article 47 applies to both B2B and B2C services connected with immovable property.',
        'exceptions' => 'A factual connection with identified property is required; remote advice and general services may remain under the ordinary B2B or B2C rules.',
        'legal_refs' => ['Article 47'],
        'sources' => [$placeSource],
    ],
    'event-admission' => [
        'title' => 'EU event admission VAT guide',
        'summary' => 'Admission to physical cultural, educational, sporting and similar events is generally taxed where the event takes place.',
        'rule' => 'Article 53 covers B2B admission and Article 54 covers relevant B2C activities. Virtual attendance can instead follow customer-location rules.',
        'exceptions' => 'Event organization services, sponsorship, virtual access and bundled services need separate classification.',
        'legal_refs' => ['Article 53', 'Article 54'],
        'sources' => [$placeSource],
    ],
];
