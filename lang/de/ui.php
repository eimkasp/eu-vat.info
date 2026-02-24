<?php

/*
|--------------------------------------------------------------------------
| UI Translations – German (Deutsch)
|--------------------------------------------------------------------------
| All translatable static strings used across blade templates.
| Organised by component / page for easy maintenance.
*/

return [

    // ── Global / Shared ──────────────────────────────────────────────────
    'site_name'           => 'EU MwSt. Info',
    'home'                => 'Startseite',
    'all_countries'       => 'Alle Länder',
    'details'             => 'Details',
    'actions'             => 'Aktionen',
    'filters'             => 'Filter',
    'search'              => 'Suchen',
    'save'                => 'Speichern',
    'calculate'           => 'Berechnen',
    'loading'             => 'Wird geladen...',
    'all_rights_reserved' => 'Alle Rechte vorbehalten.',
    'data_updated_daily'  => 'Daten werden täglich aktualisiert',
    'country'             => 'Land',
    'countries'           => 'Länder',
    'rate'                => 'Satz',
    'type'                => 'Typ',
    'language'            => 'Sprache',
    'back_to_home'        => 'Zurück zur Startseite',

    // ── Navigation ──────────────────────────────────────────────────────
    'nav' => [
        'all_countries'  => 'Alle Länder',
        'vat_calculator' => 'MwSt.-Rechner',
        'vat_widget'     => 'MwSt.-Widget',
        'vat_map'        => 'MwSt.-Karte',
        'vat_history'    => 'MwSt.-Verlauf',
    ],

    // ── Footer ──────────────────────────────────────────────────────────
    'footer' => [
        'description'      => 'Ihre vertrauenswürdige Quelle für aktuelle Mehrwertsteuersätze, Berechnungen und Compliance-Informationen für alle 27 Mitgliedstaaten der Europäischen Union. Täglich mit den neuesten Sätzen aktualisiert.',
        'vat_tools'        => 'MwSt.-Tools',
        'resources'        => 'Ressourcen',
        'partner_tools'    => 'Partner-Tools',
        'vat_calculator'   => 'MwSt.-Rechner',
        'interactive_map'  => 'Interaktive MwSt.-Karte',
        'vat_rate_history' => 'MwSt.-Satz-Verlauf',
        'embed_widget'     => 'MwSt.-Widget einbetten',
        'sitemap'          => 'Sitemap',
        'llms_data'        => 'llms.txt – KI/LLM-Daten',
        'vat_rates_api'    => 'MwSt.-Sätze API (JSON)',
        'xml_sitemap'      => 'XML-Sitemap',
        'pdf_tools'        => 'PDF-Tools – BusinessPress',
        'eu_vies'          => 'EU VIES-Validierung',
        'eu_vat_guide'     => 'EU MwSt.-Leitfaden',
    ],

    // ── Home Page ───────────────────────────────────────────────────────
    'home_page' => [
        'title'          => 'EU MwSt. Info – MwSt.-Rechner & Informationen für alle EU-Länder',
        'meta_desc'      => 'Aktuelle Mehrwertsteuersätze für alle 27 EU-Länder. Kostenloser Online-Rechner, historische Daten ab 2000, Änderungsbenachrichtigungen und Compliance-Leitfäden. Täglich aktualisiert.',
        'heading'        => 'Mehrwertsteuersätze in der',
        'heading_accent' => 'Europäischen Union',
        'subtitle'       => 'Aktuelle Regelsätze, ermäßigte Sätze und Rechner für alle 27 EU-Mitgliedstaaten. Täglich aktualisiert.',
        'search_placeholder' => 'Land suchen...',
        'th_country'     => 'Land',
        'th_standard'    => 'Regelsatz',
        'th_reduced'     => 'Ermäßigt',
        'th_actions'     => 'Aktionen',
        'view_full'      => 'Rechner & Verlauf anzeigen',
    ],

    // ── VAT Calculator ──────────────────────────────────────────────────
    'calculator' => [
        'title'              => 'MwSt.-Rechner',
        'calculate_instantly' => 'Mehrwertsteuersätze sofort berechnen',
        'amount'             => 'Betrag',
        'vat_rate'           => 'MwSt.-Satz',
        'custom_rate'        => 'Individueller Satz',
        'any_percent'        => 'Beliebig %',
        'enter_custom'       => 'Geben Sie einen beliebigen MwSt.-Prozentsatz von 0 % bis 100 % ein',
        'custom_desc'        => 'Geben Sie einen beliebigen MwSt.-Prozentsatz für Ihre Berechnung ein',
        'calculation_mode'   => 'Berechnungsmodus',
        'includes_vat'       => 'Inkl. MwSt.',
        'excludes_vat'       => 'Exkl. MwSt.',
        'extract_vat'        => 'MwSt. aus Gesamtbetrag herausrechnen',
        'add_vat'            => 'MwSt. auf Nettobetrag aufschlagen',
        'net_amount'         => 'Nettobetrag',
        'total_to_pay'       => 'Gesamtbetrag',
    ],

    // ── VAT Map ─────────────────────────────────────────────────────────
    'map' => [
        'title'            => 'Europäische MwSt.-Sätze Karte',
        'subtitle'         => 'Interaktive Karte mit den aktuellen Regelsätzen der Mehrwertsteuer in allen 27 EU-Mitgliedstaaten. Bewegen Sie den Mauszeiger über ein Land, um den Satz anzuzeigen, oder klicken Sie für vollständige Details und den Rechner.',
        'all_rates'        => 'Alle EU-MwSt.-Sätze auf einen Blick',
        'th_country'       => 'Land',
        'th_standard'      => 'Regelsatz',
        'th_reduced'       => 'Ermäßigt',
        'th_super_reduced' => 'Stark ermäßigt',
        'th_actions'       => 'Aktionen',
        'calculator_link'  => 'Rechner',
        'understanding'    => 'EU-Mehrwertsteuersätze verstehen',
        'understanding_desc' => 'Die EU verlangt von den Mitgliedstaaten einen Regelsatz der Mehrwertsteuer von mindestens 15 %. Die Sätze reichen von 17 % (Luxemburg) bis 27 % (Ungarn).',
        'standard_range'   => 'Regelsätze: 17 % – 27 %',
        'reduced_essentials' => 'Ermäßigte Sätze für Grundbedarf',
        'special_schemes'  => 'Sonderregelungen für Gebiete',
        'using_calculator' => 'Den MwSt.-Rechner verwenden',
        'using_calc_desc'  => 'Klicken Sie auf ein Land auf der Karte oben oder nutzen Sie die Tabelle, um auf die MwSt.-Tools zuzugreifen:',
        'calc_inclusive'   => 'Brutto-/Netto-MwSt. berechnen',
        'view_rate_types'  => 'Alle geltenden Satztypen anzeigen',
        'validate_vat'     => 'USt-IdNr. über VIES validieren',
    ],

    // ── VAT History / Changes ───────────────────────────────────────────
    'history' => [
        'title'            => 'Verlauf der MwSt.-Satzänderungen',
        'meta_title'       => 'Verlauf der MwSt.-Satzänderungen – EU-Länder | EU MwSt. Info',
        'meta_desc'        => 'Vollständiger Verlauf der Mehrwertsteueränderungen in allen EU-Ländern ab 2000. Verfolgen Sie Änderungen der Regel- und ermäßigten Sätze mit Stabilitätsindikatoren.',
        'subtitle'         => 'Verfolgen Sie alle MwSt.-Satzänderungen in den EU-Ländern der letzten zehn Jahre',
        'stability_title'  => 'Stabilitätsindikatoren der Länder',
        'stability_desc'   => 'Länder mit weniger MwSt.-Satzänderungen weisen ein stabileres Steuerumfeld auf',
        'changes'          => 'Änderungen',
        'excellent'        => 'Ausgezeichnet',
        'good'             => 'Gut',
        'moderate'         => 'Mäßig',
        'frequent'         => 'Häufig',
        'all_countries'    => 'Alle Länder',
        'rate_type'        => 'Satztyp',
        'all_types'        => 'Alle Typen',
        'standard_rate'    => 'Regelsatz',
        'reduced_rate'     => 'Ermäßigter Satz',
        'super_reduced_rate' => 'Stark ermäßigter Satz',
        'parking_rate'     => 'Parkingsatz',
        'all_changes'      => 'Alle Änderungen (letzte 10 Jahre)',
        'effective_from'   => 'gültig ab :date',
        'valid_until'      => 'Gültig bis: :date',
        'currently_active' => 'Derzeit aktiv',
        'view_calculator'  => 'Rechner anzeigen',
        'no_changes'       => 'Keine MwSt.-Satzänderungen gefunden, die Ihren Kriterien entsprechen',
    ],

    // ── VAT Rate Changes Widget ─────────────────────────────────────────
    'rate_changes' => [
        'title'            => 'MwSt.-Satzänderungen',
        'upcoming'         => 'Bevorstehende Änderungen',
        'recent'           => 'Letzte Änderungen',
        'no_changes'       => 'Keine aktuellen oder bevorstehenden MwSt.-Satzänderungen',
        'full_history'     => 'Vollständiger MwSt.-Verlauf',
        'explore_map'      => 'MwSt.-Karte erkunden',
    ],

    // ── Country Page ────────────────────────────────────────────────────
    'country_page' => [
        'vat_rates'       => 'MwSt.-Sätze',
        'standard_rate'   => 'Regelsatz',
        'reduced_rate'    => 'Ermäßigter Satz',
        'super_reduced'   => 'Stark ermäßigter Satz',
        'parking_rate'    => 'Parkingsatz',
        'zero_rate'       => 'Nullsatz',
        'vat_calculator'  => 'MwSt.-Rechner',
        'vat_validator'   => 'MwSt.-Validator',
        'vat_history'     => 'MwSt.-Verlauf',
        'vat_guide'       => 'MwSt.-Leitfaden',
        'related'         => 'Verwandte Länder',
    ],

    // ── Breadcrumbs ─────────────────────────────────────────────────────
    'breadcrumbs' => [
        'home'           => 'Startseite',
        'vat_calculator' => 'MwSt.-Rechner',
        'vat_map'        => 'MwSt.-Karte',
        'vat_changelog'  => 'MwSt.-Änderungsprotokoll',
        'sitemap'        => 'Sitemap',
    ],

    // ── HTML Sitemap ────────────────────────────────────────────────────
    'sitemap' => [
        'title'           => 'Sitemap',
        'subtitle'        => 'Entdecken Sie alle Seiten auf EU MwSt. Info. Finden Sie MwSt.-Rechner, Länderübersichten, Satz-Validierungen und Tools für alle 27 Mitgliedstaaten der Europäischen Union.',
        'main_pages'      => 'Hauptseiten',
        'api_data'        => 'API & Daten',
        'country_pages'   => 'Länderseiten',
        'home_all'        => 'Startseite – Alle EU-Länder',
        'home_desc'       => 'Übersicht der MwSt.-Sätze für alle 27 EU-Mitgliedstaaten',
        'calculator'      => 'MwSt.-Rechner',
        'calculator_desc' => 'Berechnen Sie MwSt.-Beträge für jedes EU-Land mit individuellen Sätzen',
        'map'             => 'Interaktive MwSt.-Karte',
        'map_desc'        => 'Visuelle Heatmap der Regelsätze in ganz Europa',
        'embed'           => 'Einbettbares MwSt.-Widget',
        'embed_desc'      => 'Betten Sie den MwSt.-Rechner auf Ihrer eigenen Website ein',
        'history'               => 'MwSt.-Satz-Verlauf',
        'history_desc'          => 'Vollständiger Verlauf der MwSt.-Satzänderungen in allen EU-Ländern',
        'heading'               => 'Site',
        'heading_accent'        => 'Map',
        'meta_title'            => 'HTML-Sitemap – Alle EU-MwSt.-Seiten | EU MwSt. Info',
        'meta_desc'             => 'Vollständige Sitemap von EU MwSt. Info. Durchsuchen Sie alle Seiten mit MwSt.-Rechnern, Länderübersichten, Validierungen und Tools für alle 27 EU-Mitgliedstaaten.',
        'schema_name'           => 'EU MwSt. Info – Vollständige Sitemap',
        'schema_desc'           => 'Durchsuchen Sie alle Seiten auf EU MwSt. Info, einschließlich länderspezifischer MwSt.-Rechner, Validierungen, Leitfäden und Tools.',
        'external_resources'    => 'Externe Ressourcen',
        'all_country_pages'     => 'Alle EU-Länder-MwSt.-Seiten',
        'country_pages_desc'    => 'MwSt.-Informationen, Rechner und Validierungen für jeden EU-Mitgliedstaat durchsuchen.',
        'standard_rate_label'   => 'Regelsatz:',
        'overview_guide'        => ':country MwSt.-Übersicht & Leitfaden',
        'country_calculator'    => ':country MwSt.-Rechner',
        'validate_numbers'      => ':country MwSt.-Nummern prüfen',
        'standalone_calculator' => ':country Einzelrechner',
        'llms_txt'              => 'llms.txt – KI/LLM-Dokumentation',
        'llms_txt_desc'         => 'Strukturierte Daten für KI-Agenten und Sprachmodelle',
        'full_vat_rates'        => 'Alle MwSt.-Sätze (Markdown)',
        'full_vat_rates_desc'   => 'Vollständige Markdown-Tabelle aller EU-MwSt.-Sätze',
        'json_api'              => 'JSON-API für KI/RAG',
        'json_api_desc'         => 'JSON-Endpunkt optimiert für RAG und LLM-Kontextabruf',
        'xml_sitemap'           => 'XML-Sitemap',
        'xml_sitemap_desc'      => 'Maschinenlesbare Sitemap für Suchmaschinen',
        'vies_validation'       => 'EU VIES MwSt.-Validierung',
        'vies_desc'             => 'Offizielle MwSt.-Nummernprüfung der Europäischen Kommission',
        'europe_guide'          => 'Your Europe – MwSt.-Leitfaden',
        'europe_guide_desc'     => 'Offizieller EU-Leitfaden zur MwSt. für Unternehmen',
        'pdf_tools'             => 'PDF-Tools von BusinessPress',
        'pdf_tools_desc'        => 'Kostenlose Online-PDF-Tools für Rechnungen und Dokumente',
        'github_repo'           => 'GitHub Repository',
        'github_desc'           => 'Open-Source-Code für EU MwSt. Info',
        'about_title'           => 'Über EU MwSt. Info',
        'about_p1'              => 'EU MwSt. Info bietet umfassende, täglich aktualisierte MwSt.-Informationen für alle 27 Mitgliedstaaten der Europäischen Union. Nutzen Sie unseren :calculator_link zur sofortigen Berechnung von MwSt.-Beträgen, erkunden Sie die :map_link zur Visualisierung der Sätze in Europa oder durchsuchen Sie alle 27 Länderseiten für detaillierte MwSt.-Leitfäden und Validierungen.',
        'about_p2'              => 'Jede Länderseite enthält einen detaillierten MwSt.-Leitfaden, einen länderspezifischen Rechner mit individuellen Sätzen und einen VIES-basierten MwSt.-Nummernprüfer. Entwickler und KI-Agenten können über den :llms_link-Standard oder die :api_link auf unsere Daten zugreifen.',
        'about_llms_label'      => 'llms.txt',
        'about_api_label'       => 'JSON API',
    ],

    // ── 404 Page ────────────────────────────────────────────────────────
    'error_404' => [
        'title'             => 'Seite nicht gefunden',
        'meta_title'        => 'Seite nicht gefunden - EU VAT Info',
        'meta_desc'         => 'Die gesuchte Seite konnte nicht gefunden werden. Durchsuchen Sie MwSt.-Sätze, Rechner und Länderanleitungen für alle 27 EU-Mitgliedstaaten.',
        'heading'           => 'Hoppla! Seite nicht gefunden',
        'message'           => 'Die Seite, die Sie suchen, existiert nicht oder wurde verschoben. Keine Sorge – es gibt viele nützliche MwSt.-Informationen zu entdecken.',
        'back'              => 'Zurück zur Startseite',
        'search_hint'       => 'Versuchen Sie stattdessen eines davon:',
        'popular_tools'     => 'MwSt.-Tools',
        'popular_countries' => 'Beliebte EU-Länder',
        'all_countries_cta' => 'Alle 27 EU-Länder anzeigen',
        'explore_resources' => 'Ressourcen & Daten',
        'tool_calculator'      => 'MwSt.-Rechner',
        'tool_calculator_desc' => 'Berechnen Sie die MwSt. sofort für jedes EU-Land mit Standard- oder benutzerdefinierten Sätzen.',
        'tool_map'             => 'Interaktive MwSt.-Karte',
        'tool_map_desc'        => 'Visualisieren und vergleichen Sie MwSt.-Sätze in allen EU-Mitgliedstaaten.',
        'tool_history'         => 'MwSt.-Satz-Verlauf',
        'tool_history_desc'    => 'Verfolgen Sie MwSt.-Satzänderungen in Europa seit 2000.',
        'tool_validator'       => 'USt-IdNr.-Prüfer',
        'tool_validator_desc'  => 'Überprüfen Sie EU-USt-IdNr. über das offizielle MIAS-System.',
        'resource_api'         => 'MwSt.-Sätze API (JSON)',
        'resource_api_desc'    => 'Greifen Sie auf EU-MwSt.-Daten über unseren JSON-Endpunkt zu.',
        'resource_llms'        => 'llms.txt - KI/LLM-Daten',
        'resource_llms_desc'   => 'Strukturierte MwSt.-Daten für KI-Agenten und Sprachmodelle.',
        'resource_sitemap'     => 'Vollständige Sitemap',
        'resource_sitemap_desc' => 'Durchsuchen Sie jede Seite auf EU VAT Info.',
        'resource_github'      => 'GitHub Repository',
        'resource_github_desc' => 'Open-Source-Code hinter EU VAT Info.',
    ],

    // ── Bottom Navigation ───────────────────────────────────────────────
    'bottom_nav' => [
        'home'       => 'Startseite',
        'calculator' => 'Rechner',
        'map'        => 'Karte',
        'history'    => 'Verlauf',
    ],

    // ── Country Stats ───────────────────────────────────────────────────
    'stats' => [
        'standard_rate'    => 'Regelsatz',
        'reduced_rate'     => 'Ermäßigter Satz',
        'super_reduced'    => 'Stark ermäßigt',
        'parking_rate'     => 'Parkingsatz',
        'eu_rank'          => 'EU-Rang',
        'currency'         => 'Währung',
        'last_updated'     => 'Zuletzt aktualisiert',
    ],

    // ── Useful Links ────────────────────────────────────────────────────
    'useful_links' => [
        'title'          => 'Nützliche Ressourcen',
        'eu_commission'  => 'Europäische Kommission – MwSt.',
        'vies_service'   => 'VIES MwSt.-Validierung',
        'your_europe'    => 'Your Europe – MwSt.',
        'tax_authority'  => 'Nationale Steuerbehörde',
    ],

    // ── Validator ───────────────────────────────────────────────────────
    'validator' => [
        'title'           => 'USt-IdNr.-Validator',
        'subtitle'        => 'EU-Umsatzsteuer-Identifikationsnummern über das VIES-System validieren',
        'enter_number'    => 'USt-IdNr. eingeben',
        'validate'        => 'Validieren',
        'valid'           => 'Gültig',
        'invalid'         => 'Ungültig',
        'company_name'    => 'Firmenname',
        'company_address' => 'Firmenanschrift',
        'request_date'    => 'Abfragedatum',
    ],

    // ── Language Switcher ───────────────────────────────────────────────
    'language_switcher' => [
        'label'    => 'Sprache',
        'current'  => 'Aktuelle Sprache: :name',
    ],
];
