<?php

/*
|--------------------------------------------------------------------------
| UI Translations – Dutch (Nederlands)
|--------------------------------------------------------------------------
| All translatable static strings used across blade templates.
| Organised by component / page for easy maintenance.
*/

return [

    // ── Global / Shared ──────────────────────────────────────────────────
    'site_name'           => 'EU VAT Info',
    'home'                => 'Home',
    'all_countries'       => 'Alle landen',
    'details'             => 'Details',
    'actions'             => 'Acties',
    'filters'             => 'Filters',
    'search'              => 'Zoeken',
    'save'                => 'Opslaan',
    'calculate'           => 'Berekenen',
    'loading'             => 'Laden...',
    'all_rights_reserved' => 'Alle rechten voorbehouden.',
    'data_updated_daily'  => 'Gegevens dagelijks bijgewerkt',
    'country'             => 'Land',
    'countries'           => 'Landen',
    'rate'                => 'Tarief',
    'type'                => 'Type',
    'language'            => 'Taal',
    'back_to_home'        => 'Terug naar home',

    // ── Navigation ──────────────────────────────────────────────────────
    'nav' => [
        'all_countries'  => 'Alle landen',
        'vat_calculator' => 'BTW-calculator',
        'vat_widget'     => 'BTW-widget',
        'vat_map'        => 'BTW-kaart',
        'vat_history'    => 'BTW-geschiedenis',
    ],

    // ── Footer ──────────────────────────────────────────────────────────
    'footer' => [
        'description'      => 'Uw betrouwbare bron voor actuele BTW-tarieven, berekeningen en nalevingsinformatie voor alle 27 lidstaten van de Europese Unie. Dagelijks bijgewerkt met de nieuwste tarieven.',
        'vat_tools'        => 'BTW-tools',
        'resources'        => 'Bronnen',
        'partner_tools'    => 'Partnertools',
        'vat_calculator'   => 'BTW-calculator',
        'interactive_map'  => 'Interactieve BTW-kaart',
        'vat_rate_history' => 'Geschiedenis BTW-tarieven',
        'embed_widget'     => 'Insluitbare BTW-widget',
        'sitemap'          => 'Sitemap',
        'llms_data'        => 'llms.txt - AI/LLM-gegevens',
        'vat_rates_api'    => 'BTW-tarieven API (JSON)',
        'xml_sitemap'      => 'XML-sitemap',
        'pdf_tools'        => 'PDF-tools - BusinessPress',
        'eu_vies'          => 'EU VIES-validatie',
        'eu_vat_guide'     => 'EU BTW-gids',
    ],

    // ── Home Page ───────────────────────────────────────────────────────
    'home_page' => [
        'title'          => 'EU VAT Info - BTW-tarieven calculator & informatie voor alle EU-landen',
        'meta_desc'      => 'Actuele BTW-tarieven voor alle 27 EU-landen. Gratis online calculator, historische gegevens vanaf 2000, meldingen bij tariefwijzigingen en nalevingsgidsen. Dagelijks bijgewerkt.',
        'heading'        => 'BTW-tarieven in de',
        'heading_accent' => 'Europese Unie',
        'subtitle'       => 'Actuele standaard BTW-tarieven, verlaagde tarieven en calculator voor alle 27 EU-lidstaten. Dagelijks bijgewerkt.',
        'search_placeholder' => 'Zoek een land...',
        'th_country'     => 'Land',
        'th_standard'    => 'Standaardtarief',
        'th_reduced'     => 'Verlaagd',
        'th_actions'     => 'Acties',
        'view_full'      => 'Bekijk volledige calculator & geschiedenis',
    ],

    // ── VAT Calculator ──────────────────────────────────────────────────
    'calculator' => [
        'title'              => 'BTW-calculator',
        'calculate_instantly' => 'Bereken BTW-tarieven direct',
        'amount'             => 'Bedrag',
        'vat_rate'           => 'BTW-tarief',
        'custom_rate'        => 'Aangepast tarief',
        'any_percent'        => 'Elk %',
        'enter_custom'       => 'Voer een BTW-percentage in van 0% tot 100%',
        'custom_desc'        => 'Voer een willekeurig BTW-percentage in voor uw berekening',
        'calculation_mode'   => 'Berekeningsmodus',
        'includes_vat'       => 'Inclusief BTW',
        'excludes_vat'       => 'Exclusief BTW',
        'extract_vat'        => 'BTW uit totaal halen',
        'add_vat'            => 'BTW toevoegen aan nettobedrag',
        'net_amount'         => 'Nettobedrag',
        'total_to_pay'       => 'Totaal te betalen',
    ],

    // ── VAT Map ─────────────────────────────────────────────────────────
    'map' => [
        'title'            => 'Europese BTW-tarieven kaart',
        'subtitle'         => 'Interactieve kaart met de huidige standaard BTW-tarieven in alle 27 EU-lidstaten. Beweeg over een land om het tarief te bekijken, of klik voor alle details en toegang tot de calculator.',
        'all_rates'        => 'Alle EU BTW-tarieven in één overzicht',
        'th_country'       => 'Land',
        'th_standard'      => 'Standaard',
        'th_reduced'       => 'Verlaagd',
        'th_super_reduced' => 'Super verlaagd',
        'th_actions'       => 'Acties',
        'calculator_link'  => 'Calculator',
        'understanding'    => 'EU BTW-tarieven begrijpen',
        'understanding_desc' => 'De EU vereist dat lidstaten een standaard BTW-tarief van minimaal 15% hanteren. Tarieven variëren van 17% (Luxemburg) tot 27% (Hongarije).',
        'standard_range'   => 'Standaardtarieven: 17% – 27%',
        'reduced_essentials' => 'Verlaagde tarieven voor eerste levensbehoeften',
        'special_schemes'  => 'Speciale regelingen voor gebiedsdelen',
        'using_calculator' => 'De BTW-calculator gebruiken',
        'using_calc_desc'  => 'Klik op een land op de kaart hierboven, of gebruik de tabel om toegang te krijgen tot BTW-tools:',
        'calc_inclusive'   => 'BTW inclusief/exclusief berekenen',
        'view_rate_types'  => 'Alle toepasselijke tarieftypes bekijken',
        'validate_vat'     => 'BTW-nummers valideren via VIES',
    ],

    // ── VAT History / Changes ───────────────────────────────────────────
    'history' => [
        'title'            => 'Geschiedenis van BTW-tariefwijzigingen',
        'meta_title'       => 'Geschiedenis van BTW-tariefwijzigingen - EU-landen | EU VAT Info',
        'meta_desc'        => 'Volledige geschiedenis van BTW-tariefwijzigingen in alle EU-landen vanaf 2000. Volg standaard- en verlaagde tariefwijzigingen met stabiliteitsindicatoren per land.',
        'subtitle'         => 'Volg alle BTW-tariefwijzigingen in EU-landen van het afgelopen decennium',
        'stability_title'  => 'Stabiliteitsindicatoren per land',
        'stability_desc'   => 'Landen met minder BTW-tariefwijzigingen duiden op een stabieler fiscaal klimaat',
        'changes'          => 'wijzigingen',
        'excellent'        => 'Uitstekend',
        'good'             => 'Goed',
        'moderate'         => 'Matig',
        'frequent'         => 'Frequent',
        'all_countries'    => 'Alle landen',
        'rate_type'        => 'Tarieftype',
        'all_types'        => 'Alle types',
        'standard_rate'    => 'Standaardtarief',
        'reduced_rate'     => 'Verlaagd tarief',
        'super_reduced_rate' => 'Super verlaagd tarief',
        'parking_rate'     => 'Parkeertarief',
        'all_changes'      => 'Alle wijzigingen (afgelopen 10 jaar)',
        'effective_from'   => 'van kracht sinds :date',
        'valid_until'      => 'Geldig tot: :date',
        'currently_active' => 'Momenteel actief',
        'view_calculator'  => 'Naar calculator',
        'no_changes'       => 'Geen BTW-tariefwijzigingen gevonden die aan uw criteria voldoen',
    ],

    // ── VAT Rate Changes Widget ─────────────────────────────────────────
    'rate_changes' => [
        'title'            => 'BTW-tariefwijzigingen',
        'upcoming'         => 'Aanstaande wijzigingen',
        'recent'           => 'Recente wijzigingen',
        'no_changes'       => 'Geen recente of aanstaande BTW-tariefwijzigingen',
        'full_history'     => 'Volledige BTW-geschiedenis',
        'explore_map'      => 'BTW-kaart verkennen',
    ],

    // ── Country Page ────────────────────────────────────────────────────
    'country_page' => [
        'vat_rates'       => 'BTW-tarieven',
        'standard_rate'   => 'Standaardtarief',
        'reduced_rate'    => 'Verlaagd tarief',
        'super_reduced'   => 'Super verlaagd tarief',
        'parking_rate'    => 'Parkeertarief',
        'zero_rate'       => 'Nultarief',
        'vat_calculator'  => 'BTW-calculator',
        'vat_validator'   => 'BTW-validator',
        'vat_history'     => 'BTW-geschiedenis',
        'vat_guide'       => 'BTW-gids',
        'related'         => 'Gerelateerde landen',
    ],

    // ── Breadcrumbs ─────────────────────────────────────────────────────
    'breadcrumbs' => [
        'home'           => 'Home',
        'vat_calculator' => 'BTW-calculator',
        'vat_map'        => 'BTW-kaart',
        'vat_changelog'  => 'BTW-wijzigingslogboek',
        'sitemap'        => 'Sitemap',
    ],

    // ── HTML Sitemap ────────────────────────────────────────────────────
    'sitemap' => [
        'title'           => 'Sitemap',
        'subtitle'        => 'Verken alle pagina\'s op EU VAT Info. Vind BTW-calculators, landengidsen, tariefvalidators en tools voor alle 27 lidstaten van de Europese Unie.',
        'main_pages'      => 'Hoofdpagina\'s',
        'api_data'        => 'API & gegevens',
        'country_pages'   => 'Landenpagina\'s',
        'home_all'        => 'Home - Alle EU-landen',
        'home_desc'       => 'Overzicht van BTW-tarieven voor alle 27 EU-lidstaten',
        'calculator'      => 'BTW-calculator',
        'calculator_desc' => 'Bereken BTW-bedragen voor elk EU-land met aangepaste tarieven',
        'map'             => 'Interactieve BTW-kaart',
        'map_desc'        => 'Visuele heatmap van standaard BTW-tarieven in Europa',
        'embed'           => 'Insluitbare BTW-widget',
        'embed_desc'      => 'Sluit de BTW-calculator in op uw eigen website',
        'history'               => 'Geschiedenis BTW-tarieven',
        'history_desc'          => 'Volledige geschiedenis van BTW-tariefwijzigingen in alle EU-landen',
        'heading'               => 'Site',
        'heading_accent'        => 'Map',
        'meta_title'            => 'HTML-sitemap – Alle EU BTW-pagina\'s | EU VAT Info',
        'meta_desc'             => 'Volledige sitemap van EU VAT Info. Blader door alle pagina\'s met BTW-calculators, landengidsen, validators en tools voor alle 27 EU-lidstaten.',
        'schema_name'           => 'EU VAT Info – Volledige sitemap',
        'schema_desc'           => 'Blader door alle pagina\'s op EU VAT Info, waaronder BTW-calculators per land, validators, gidsen en tools.',
        'external_resources'    => 'Externe bronnen',
        'all_country_pages'     => 'Alle EU-landen BTW-pagina\'s',
        'country_pages_desc'    => 'Blader door BTW-informatie, calculators en validators voor elke EU-lidstaat.',
        'standard_rate_label'   => 'Standaardtarief:',
        'overview_guide'        => ':country BTW-overzicht & gids',
        'country_calculator'    => ':country BTW-calculator',
        'validate_numbers'      => ':country BTW-nummers valideren',
        'standalone_calculator' => ':country Zelfstandige calculator',
        'llms_txt'              => 'llms.txt – AI/LLM-documentatie',
        'llms_txt_desc'         => 'Gestructureerde data voor AI-agents en taalmodellen',
        'full_vat_rates'        => 'Alle BTW-tarieven (Markdown)',
        'full_vat_rates_desc'   => 'Volledige Markdown-tabel van alle EU BTW-tarieven',
        'json_api'              => 'JSON API voor AI/RAG',
        'json_api_desc'         => 'JSON-endpoint geoptimaliseerd voor RAG en LLM-contextophaling',
        'xml_sitemap'           => 'XML Sitemap',
        'xml_sitemap_desc'      => 'Machineleesbare sitemap voor zoekmachines',
        'vies_validation'       => 'EU VIES BTW-validatie',
        'vies_desc'             => 'Officiële BTW-nummerverificatie van de Europese Commissie',
        'europe_guide'          => 'Your Europe – BTW-gids',
        'europe_guide_desc'     => 'Officiële EU-gids over BTW voor bedrijven',
        'pdf_tools'             => 'PDF-tools van BusinessPress',
        'pdf_tools_desc'        => 'Gratis online PDF-tools voor facturen en documenten',
        'github_repo'           => 'GitHub Repository',
        'github_desc'           => 'Open source code van EU VAT Info',
        'about_title'           => 'Over EU VAT Info',
        'about_p1'              => 'EU VAT Info biedt uitgebreide, dagelijks bijgewerkte BTW-informatie voor alle 27 lidstaten van de Europese Unie. Gebruik onze :calculator_link om BTW-bedragen direct te berekenen, verken de :map_link om tarieven in heel Europa te visualiseren, of blader hieronder door alle 27 landenpagina\'s voor gedetailleerde BTW-gidsen en validators.',
        'about_p2'              => 'Elke landenpagina bevat een gedetailleerde BTW-gids, een landspecifieke calculator met ondersteuning voor aangepaste tarieven, en een VIES-gebaseerde BTW-nummervalidator. Ontwikkelaars en AI-agents kunnen via de :llms_link-standaard of de :api_link toegang krijgen tot onze gegevens.',
        'about_llms_label'      => 'llms.txt',
        'about_api_label'       => 'JSON API',
    ],

    // ── 404 Page ────────────────────────────────────────────────────────
    'error_404' => [
        'title'             => 'Pagina niet gevonden',
        'meta_title'        => 'Pagina niet gevonden - EU VAT Info',
        'meta_desc'         => 'De pagina die u zocht kon niet worden gevonden. Bekijk BTW-tarieven, calculators en landengidsen voor alle 27 EU-lidstaten.',
        'heading'           => 'Oeps! Pagina niet gevonden',
        'message'           => 'De pagina die u zoekt bestaat niet of is verplaatst. Geen zorgen — er is veel nuttige BTW-informatie te ontdekken.',
        'back'              => 'Terug naar home',
        'search_hint'       => 'Probeer een van deze:',
        'popular_tools'     => 'BTW-tools',
        'popular_countries' => 'Populaire EU-landen',
        'all_countries_cta' => 'Bekijk alle 27 EU-landen',
        'explore_resources' => 'Bronnen & Data',
        'tool_calculator'      => 'BTW-calculator',
        'tool_calculator_desc' => 'Bereken BTW direct voor elk EU-land met standaard of aangepaste tarieven.',
        'tool_map'             => 'Interactieve BTW-kaart',
        'tool_map_desc'        => 'Visualiseer en vergelijk BTW-tarieven in alle EU-lidstaten.',
        'tool_history'         => 'BTW-tarief geschiedenis',
        'tool_history_desc'    => 'Volg BTW-tariefwijzigingen in Europa vanaf 2000.',
        'tool_validator'       => 'BTW-nummer validator',
        'tool_validator_desc'  => 'Controleer EU BTW-nummers via het officiële VIES-systeem.',
        'resource_api'         => 'BTW-tarieven API (JSON)',
        'resource_api_desc'    => 'Toegang tot EU BTW-tariefgegevens via ons JSON-eindpunt.',
        'resource_llms'        => 'llms.txt - AI/LLM-gegevens',
        'resource_llms_desc'   => 'Gestructureerde BTW-gegevens voor AI-agents en taalmodellen.',
        'resource_sitemap'     => 'Volledige sitemap',
        'resource_sitemap_desc' => 'Blader door elke pagina op EU VAT Info.',
        'resource_github'      => 'GitHub Repository',
        'resource_github_desc' => 'Open-source code achter EU VAT Info.',
    ],

    // ── Bottom Navigation ───────────────────────────────────────────────
    'bottom_nav' => [
        'home'       => 'Home',
        'calculator' => 'Calculator',
        'map'        => 'Kaart',
        'history'    => 'Geschiedenis',
    ],

    // ── Country Stats ───────────────────────────────────────────────────
    'stats' => [
        'standard_rate'    => 'Standaardtarief',
        'reduced_rate'     => 'Verlaagd tarief',
        'super_reduced'    => 'Super verlaagd',
        'parking_rate'     => 'Parkeertarief',
        'eu_rank'          => 'EU-ranglijst',
        'currency'         => 'Valuta',
        'last_updated'     => 'Laatst bijgewerkt',
    ],

    // ── Useful Links ────────────────────────────────────────────────────
    'useful_links' => [
        'title'          => 'Nuttige bronnen',
        'eu_commission'  => 'Europese Commissie – BTW',
        'vies_service'   => 'VIES BTW-validatie',
        'your_europe'    => 'Uw Europa – BTW',
        'tax_authority'  => 'Nationale belastingdienst',
    ],

    // ── Validator ───────────────────────────────────────────────────────
    'validator' => [
        'title'           => 'BTW-nummervalidator',
        'subtitle'        => 'Valideer EU BTW-nummers via het VIES-systeem',
        'enter_number'    => 'Voer BTW-nummer in',
        'validate'        => 'Valideren',
        'valid'           => 'Geldig',
        'invalid'         => 'Ongeldig',
        'company_name'    => 'Bedrijfsnaam',
        'company_address' => 'Bedrijfsadres',
        'request_date'    => 'Aanvraagdatum',
    ],

    // ── Language Switcher ───────────────────────────────────────────────
    'language_switcher' => [
        'label'    => 'Taal',
        'current'  => 'Huidige taal: :name',
    ],
];
