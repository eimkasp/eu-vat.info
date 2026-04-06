<?php

/**
 * Add vies_page translations and country_page validator CTA keys to all language files.
 * Run: php scripts/add-vies-page-translations.php
 */

$basePath = __DIR__ . '/../lang';

// English is already done, skip it
$translations = [
    'de' => [
        'vies_page' => [
            'title' => 'VIES USt-IdNr.-Prüfung — EU USt-Nummern online überprüfen',
            'description' => 'Kostenloses VIES-Prüftool für USt-IdNr. Überprüfen Sie jede EU-USt-Nummer über die offizielle Datenbank der Europäischen Kommission.',
            'country_title' => ':country USt-IdNr.-Prüfung — :country USt-Nummern über VIES verifizieren',
            'country_description' => ':country (:code) USt-Nummern über die offizielle EU VIES-Datenbank validieren.',
            'h1' => 'VIES USt-IdNr.-Prüfung',
            'country_h1' => ':country USt-IdNr.-Prüfung',
            'subtitle' => 'Überprüfen Sie jede EU-USt-Nummer über die offizielle VIES-Datenbank der Europäischen Kommission.',
            'country_subtitle' => ':country (:code) USt-Nummern über die offizielle EU VIES-Datenbank validieren.',
            'nav_title' => 'USt-IdNr.-Prüfung',
            'vat_number_label' => 'USt-IdNr.',
            'vat_placeholder' => 'z.B. LT100019070512 oder 123456789',
            'country_label' => 'Land',
            'select_country' => 'Land auswählen',
            'search_countries' => 'Länder suchen...',
            'validate_btn' => 'Prüfen',
            'auto_detect_hint' => 'Das Land wird automatisch aus dem USt-Nummern-Präfix erkannt. ',
            'try_example' => 'Versuchen Sie LT100019070512',
            'country_validators' => 'Nach Land prüfen',
            'what_is_vies' => 'Was ist VIES?',
            'about_vat_country' => 'USt-Prüfung in :country',
            'vies_p1' => 'VIES (VAT Information Exchange System) ist der offizielle Dienst der Europäischen Kommission zur Überprüfung von USt-IdNr.',
            'vies_p2' => 'Bei der Überprüfung wird die nationale USt-Datenbank des jeweiligen EU-Landes in Echtzeit abgefragt.',
            'vies_p3' => 'Unser Tool fügt eine Caching-Schicht hinzu, damit bereits geprüfte Nummern sofort Ergebnisse liefern.',
            'country_vies_p1' => ':country USt-Nummern verwenden das Präfix :code gefolgt von der Registrierungsnummer.',
            'country_vies_p2' => ':country wendet einen USt-Normalsatz von :rate% an. Nutzen Sie unseren :calculator_link zur Berechnung von USt-Beträgen.',
            'country_calculator_link' => ':country USt-Rechner',
        ],
        'country_page' => [
            'validate_vat_cta' => ':country USt-Nummern überprüfen',
            'validate_vat_cta_desc' => 'Überprüfen Sie jede :country USt-Nummer über die offizielle EU VIES-Datenbank.',
        ],
    ],
    'fr' => [
        'vies_page' => [
            'title' => 'Vérification de numéro de TVA VIES — Vérifiez les numéros de TVA UE en ligne',
            'description' => 'Outil gratuit de vérification de numéro de TVA VIES. Vérifiez tout numéro de TVA UE via la base de données officielle de la Commission européenne.',
            'country_title' => 'Vérification de numéro de TVA :country — Vérifier les numéros de TVA :country via VIES',
            'country_description' => 'Validez les numéros de TVA :country (:code) via la base de données officielle VIES de l\'UE.',
            'h1' => 'Vérification de numéro de TVA VIES',
            'country_h1' => 'Vérification de numéro de TVA :country',
            'subtitle' => 'Vérifiez tout numéro de TVA UE via la base de données officielle VIES de la Commission européenne.',
            'country_subtitle' => 'Validez les numéros de TVA :country (:code) via la base de données officielle VIES de l\'UE.',
            'nav_title' => 'Vérification de TVA',
            'vat_number_label' => 'Numéro de TVA',
            'vat_placeholder' => 'ex. LT100019070512 ou 123456789',
            'country_label' => 'Pays',
            'select_country' => 'Sélectionner un pays',
            'search_countries' => 'Rechercher un pays...',
            'validate_btn' => 'Vérifier',
            'auto_detect_hint' => 'Le pays est détecté automatiquement à partir du préfixe du numéro de TVA. ',
            'try_example' => 'Essayez LT100019070512',
            'country_validators' => 'Vérifier par pays',
            'what_is_vies' => 'Qu\'est-ce que VIES ?',
            'about_vat_country' => 'Validation TVA en :country',
            'vies_p1' => 'VIES est le service officiel de la Commission européenne pour la vérification des numéros de TVA.',
            'vies_p2' => 'Le système vérifie les bases de données nationales de TVA de chaque pays de l\'UE en temps réel.',
            'vies_p3' => 'Notre outil ajoute une couche de mise en cache pour des résultats plus rapides.',
            'country_vies_p1' => 'Les numéros de TVA :country utilisent le préfixe :code suivi du numéro d\'enregistrement.',
            'country_vies_p2' => ':country applique un taux de TVA standard de :rate%. Utilisez notre :calculator_link pour calculer les montants de TVA.',
            'country_calculator_link' => 'Calculateur de TVA :country',
        ],
        'country_page' => [
            'validate_vat_cta' => 'Vérifier les numéros de TVA :country',
            'validate_vat_cta_desc' => 'Vérifiez tout numéro de TVA :country via la base de données officielle VIES de l\'UE.',
        ],
    ],
];

// For other languages, use English as fallback with the language name context
// These will work fine since :country and :code are dynamic placeholders
$defaultTranslation = [
    'vies_page' => [
        'title' => 'VIES VAT Number Validator — Verify EU VAT Numbers Online',
        'description' => 'Free VIES VAT number validation tool. Verify any EU VAT number instantly using the official European Commission VIES database.',
        'country_title' => ':country VAT Number Validator — Verify :country VAT Numbers via VIES',
        'country_description' => 'Validate :country (:code) VAT numbers instantly using the official EU VIES database.',
        'h1' => 'VIES VAT Number Validator',
        'country_h1' => ':country VAT Number Validator',
        'subtitle' => 'Verify any EU VAT number using the official European Commission VIES database. Results are cached for faster lookups.',
        'country_subtitle' => 'Validate :country (:code) VAT numbers using the official EU VIES database.',
        'nav_title' => 'VAT Number Validator',
        'vat_number_label' => 'VAT Number',
        'vat_placeholder' => 'e.g. LT100019070512 or 123456789',
        'country_label' => 'Country',
        'select_country' => 'Select country',
        'search_countries' => 'Search countries...',
        'validate_btn' => 'Validate',
        'auto_detect_hint' => 'Country is auto-detected from VAT number prefix. ',
        'try_example' => 'Try LT100019070512',
        'country_validators' => 'Validate by Country',
        'what_is_vies' => 'What is VIES?',
        'about_vat_country' => 'VAT Validation in :country',
        'vies_p1' => 'VIES (VAT Information Exchange System) is the official European Commission service for verifying VAT identification numbers of businesses registered in EU member states.',
        'vies_p2' => 'When you validate a VAT number through VIES, the system checks against the national VAT databases of each EU country in real-time.',
        'vies_p3' => 'Our validator adds a caching layer on top of VIES, so previously checked numbers return results instantly.',
        'country_vies_p1' => ':country VAT numbers use the prefix :code followed by the registration number.',
        'country_vies_p2' => ':country applies a standard VAT rate of :rate%. Use our :calculator_link to calculate VAT amounts.',
        'country_calculator_link' => ':country VAT Calculator',
    ],
    'country_page' => [
        'validate_vat_cta' => 'Validate :country VAT Numbers',
        'validate_vat_cta_desc' => 'Verify any :country VAT number instantly using the official EU VIES database.',
    ],
];

$locales = ['bg', 'cs', 'da', 'de', 'el', 'es', 'et', 'fi', 'fr', 'ga', 'hr', 'hu', 'it', 'lt', 'lv', 'mt', 'nl', 'pl', 'pt', 'ro', 'sk', 'sl', 'sv'];

foreach ($locales as $locale) {
    $filePath = "$basePath/$locale/ui.php";
    if (!file_exists($filePath)) {
        echo "SKIP: $locale (file not found)\n";
        continue;
    }

    $content = file_get_contents($filePath);

    // Check if vies_page already added
    if (str_contains($content, "'vies_page'")) {
        echo "SKIP: $locale (vies_page already exists)\n";
        continue;
    }

    $trans = $translations[$locale] ?? $defaultTranslation;

    // Build the vies_page array as PHP code
    $viesPageCode = "\n    // ── VIES Validator Page ─────────────────────────────────────────────\n";
    $viesPageCode .= "    'vies_page' => [\n";
    foreach ($trans['vies_page'] as $key => $value) {
        $escaped = str_replace("'", "\\'", $value);
        $viesPageCode .= "        '$key' => '$escaped',\n";
    }
    $viesPageCode .= "    ],\n";

    // Insert before the validator section
    $needle = "'validator' =>";
    $needleAlt = "    // ── Validator ─";
    
    if (str_contains($content, $needleAlt)) {
        $content = str_replace($needleAlt, $viesPageCode . "\n" . $needleAlt, $content);
    } elseif (str_contains($content, "  'validator' =>")) {
        // Match the 'validator' => line with proper indentation
        $content = preg_replace(
            "/(\s+'validator'\s*=>\s*\n?\s*array\s*\()/",
            $viesPageCode . "\n$1",
            $content,
            1
        );
        if (!str_contains($content, "'vies_page'")) {
            // fallback: try alternate format
            $content = preg_replace(
                "/(\s+'validator'\s*=>\s*\[)/",
                $viesPageCode . "\n$1",
                $content,
                1
            );
        }
    } else {
        // Try inserting before the last ];
        $content = preg_replace('/\];\s*$/', $viesPageCode . "\n];\n", $content);
    }

    // Add country_page keys (validate_vat_cta, validate_vat_cta_desc)
    if (!str_contains($content, "'validate_vat_cta'")) {
        // Find 'available' key in country_page and add after it
        $ctaCode = "";
        foreach ($trans['country_page'] as $key => $value) {
            $escaped = str_replace("'", "\\'", $value);
            $ctaCode .= "        '$key' => '$escaped',\n";
        }

        // Try to insert after 'country_pages_desc' key
        if (preg_match("/('country_pages_desc'\s*=>\s*'[^']*',?\s*\n)/", $content, $matches)) {
            $content = str_replace($matches[1], $matches[1] . $ctaCode, $content);
        }
    }

    file_put_contents($filePath, $content);
    echo "OK: $locale\n";
}

echo "\nDone!\n";
