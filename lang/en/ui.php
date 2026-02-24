<?php

/*
|--------------------------------------------------------------------------
| UI Translations – English (Default)
|--------------------------------------------------------------------------
| All translatable static strings used across blade templates.
| Organised by component / page for easy maintenance.
*/

return [

    // ── Global / Shared ──────────────────────────────────────────────────
    'site_name'           => 'EU VAT Info',
    'home'                => 'Home',
    'all_countries'       => 'All Countries',
    'details'             => 'Details',
    'actions'             => 'Actions',
    'filters'             => 'Filters',
    'search'              => 'Search',
    'save'                => 'Save',
    'calculate'           => 'Calculate',
    'loading'             => 'Loading...',
    'all_rights_reserved' => 'All rights reserved.',
    'data_updated_daily'  => 'Always up to date',
    'country'             => 'Country',
    'countries'           => 'Countries',
    'rate'                => 'Rate',
    'type'                => 'Type',
    'language'            => 'Language',
    'back_to_home'        => 'Back to Home',

    // ── Navigation ──────────────────────────────────────────────────────
    'nav' => [
        'all_countries'  => 'All Countries',
        'vat_calculator' => 'VAT Calculator',
        'vat_widget'     => 'VAT Widget',
        'vat_map'        => 'VAT Map',
        'vat_history'    => 'VAT History',
    ],

    // ── Footer ──────────────────────────────────────────────────────────
    'footer' => [
        'description'      => 'Your trusted source for current VAT rates, calculations, and compliance information across all 27 European Union member states.',
        'vat_tools'        => 'VAT Tools',
        'resources'        => 'Resources',
        'partner_tools'    => 'Partner Tools',
        'vat_calculator'   => 'VAT Calculator',
        'interactive_map'  => 'Interactive VAT Map',
        'vat_rate_history' => 'VAT Rate History',
        'embed_widget'     => 'Embed VAT Widget',
        'sitemap'          => 'Sitemap',
        'llms_data'        => 'llms.txt - AI/LLM Data',
        'vat_rates_api'    => 'VAT Rates API (JSON)',
        'xml_sitemap'      => 'XML Sitemap',
        'pdf_tools'        => 'PDF Tools - BusinessPress',
        'eu_vies'          => 'EU VIES Validation',
        'eu_vat_guide'     => 'EU VAT Guide',
    ],

    // ── Home Page ───────────────────────────────────────────────────────
    'home_page' => [
        'title'          => 'EU VAT Info - VAT Rates Calculator & Information for All EU Countries',
        'meta_desc'      => 'Compare VAT rates across all 27 EU countries. Free online calculator, historical rate data, and compliance guides for every member state.',
        'heading'        => 'VAT Rates in the',
        'heading_accent' => 'European Union',
        'subtitle'       => 'Compare standard and reduced VAT rates, calculate taxes, and stay compliant across all 27 EU member states.',
        'search_placeholder' => 'Search for a country...',
        'th_country'     => 'Country',
        'th_standard'    => 'Standard Rate',
        'th_reduced'     => 'Reduced',
        'th_actions'     => 'Actions',
        'view_full'      => 'View full calculator & history',
    ],

    // ── VAT Calculator ──────────────────────────────────────────────────
    'calculator' => [
        'title'              => 'VAT Calculator',
        'calculate_instantly' => 'Calculate VAT rates instantly',
        'amount'             => 'Amount',
        'vat_rate'           => 'VAT Rate',
        'custom_rate'        => 'Custom Rate',
        'any_percent'        => 'Any %',
        'enter_custom'       => 'Enter any VAT percentage from 0% to 100%',
        'custom_desc'        => 'Enter any VAT percentage for your calculation',
        'calculation_mode'   => 'Calculation Mode',
        'includes_vat'       => 'Includes VAT',
        'excludes_vat'       => 'Excludes VAT',
        'extract_vat'        => 'Extract VAT from total',
        'add_vat'            => 'Add VAT to net amount',
        'net_amount'         => 'Net Amount',
        'total_to_pay'       => 'Total to Pay',
    ],

    // ── VAT Map ─────────────────────────────────────────────────────────
    'map' => [
        'title'            => 'European VAT Rates Map',
        'subtitle'         => 'Interactive map showing current standard VAT rates across all 27 EU member states. Hover over any country to preview its rate, or click to see full details and access the calculator.',
        'all_rates'        => 'All EU VAT Rates at a Glance',
        'th_country'       => 'Country',
        'th_standard'      => 'Standard',
        'th_reduced'       => 'Reduced',
        'th_super_reduced' => 'Super Reduced',
        'th_actions'       => 'Actions',
        'calculator_link'  => 'Calculator',
        'understanding'    => 'Understanding EU VAT Rates',
        'understanding_desc' => 'The EU requires member states to apply a standard VAT rate of at least 15%. Rates range from 17% (Luxembourg) to 27% (Hungary).',
        'standard_range'   => 'Standard rates: 17% – 27%',
        'reduced_essentials' => 'Reduced rates for essentials',
        'special_schemes'  => 'Special schemes for territories',
        'using_calculator' => 'Using the VAT Calculator',
        'using_calc_desc'  => 'Click any country on the map above, or use the table to access dedicated VAT tools:',
        'calc_inclusive'   => 'Calculate inclusive/exclusive VAT',
        'view_rate_types'  => 'View all applicable rate types',
        'validate_vat'     => 'Validate VAT numbers via VIES',
    ],

    // ── VAT History / Changes ───────────────────────────────────────────
    'history' => [
        'title'            => 'VAT Rate Changes History',
        'meta_title'       => 'VAT Rate Changes History - EU Countries | EU VAT Info',
        'meta_desc'        => 'Complete history of VAT rate changes across all EU countries from 2000 onwards. Track standard and reduced rate modifications with country stability indicators.',
        'subtitle'         => 'Track all VAT rate modifications across EU countries over the past decade',
        'stability_title'  => 'Country Stability Indicators',
        'stability_desc'   => 'Countries with fewer VAT rate changes indicate more stable tax environments',
        'changes'          => 'changes',
        'excellent'        => 'Excellent',
        'good'             => 'Good',
        'moderate'         => 'Moderate',
        'frequent'         => 'Frequent',
        'all_countries'    => 'All Countries',
        'rate_type'        => 'Rate Type',
        'all_types'        => 'All Types',
        'standard_rate'    => 'Standard Rate',
        'reduced_rate'     => 'Reduced Rate',
        'super_reduced_rate' => 'Super Reduced Rate',
        'parking_rate'     => 'Parking Rate',
        'all_changes'      => 'All Changes (Past 10 Years)',
        'effective_from'   => 'effective from :date',
        'valid_until'      => 'Valid until: :date',
        'currently_active' => 'Currently active',
        'view_calculator'  => 'View Calculator',
        'no_changes'       => 'No VAT rate changes found matching your criteria',
    ],

    // ── VAT Rate Changes Widget ─────────────────────────────────────────
    'rate_changes' => [
        'title'            => 'VAT Rate Changes',
        'upcoming'         => 'Upcoming Changes',
        'recent'           => 'Recent Changes',
        'no_changes'       => 'No recent or upcoming VAT rate changes',
        'full_history'     => 'Full VAT History',
        'explore_map'      => 'Explore VAT Map',
    ],

    // ── Country Page ────────────────────────────────────────────────────
    'country_page' => [
        'vat_rates'       => 'VAT Rates',
        'standard_rate'   => 'Standard Rate',
        'reduced_rate'    => 'Reduced Rate',
        'super_reduced'   => 'Super Reduced Rate',
        'parking_rate'    => 'Parking Rate',
        'zero_rate'       => 'Zero Rate',
        'vat_calculator'  => 'VAT Calculator',
        'vat_validator'   => 'VAT Validator',
        'vat_history'     => 'VAT History',
        'vat_guide'       => 'VAT Guide',
        'related'         => 'Related Countries',
    ],

    // ── Breadcrumbs ─────────────────────────────────────────────────────
    'breadcrumbs' => [
        'home'           => 'Home',
        'vat_calculator' => 'VAT Calculator',
        'vat_map'        => 'VAT Map',
        'vat_changelog'  => 'VAT Changelog',
        'sitemap'        => 'Sitemap',
    ],

    // ── HTML Sitemap ────────────────────────────────────────────────────
    'sitemap' => [
        'title'                 => 'Site Map',
        'heading'               => 'Site',
        'heading_accent'        => 'Map',
        'subtitle'              => 'Explore every page on EU VAT Info. Find VAT calculators, country guides, rate validators, and tools for all 27 European Union member states.',
        'meta_title'            => 'HTML Sitemap - All EU VAT Pages | EU VAT Info',
        'meta_desc'             => 'Complete sitemap of EU VAT Info. Browse all pages including VAT calculators, country guides, validators, and tools for all 27 EU member states.',
        'schema_name'           => 'EU VAT Info - Complete Sitemap',
        'schema_desc'           => 'Browse all pages on EU VAT Info including country-specific VAT calculators, validators, guides, and tools.',
        'main_pages'            => 'Main Pages',
        'api_data'              => 'API & Data',
        'external_resources'    => 'External Resources',
        'country_pages'         => 'Country Pages',
        'all_country_pages'     => 'All EU Country VAT Pages',
        'country_pages_desc'    => 'Browse VAT information, calculators, and validators for each EU member state.',
        'home_all'              => 'Home - All EU Countries',
        'home_desc'             => 'Overview of VAT rates for all 27 EU member states',
        'calculator'            => 'VAT Calculator',
        'calculator_desc'       => 'Calculate VAT amounts for any EU country with custom rates',
        'map'                   => 'Interactive VAT Map',
        'map_desc'              => 'Visual heatmap of standard VAT rates across Europe',
        'embed'                 => 'Embeddable VAT Widget',
        'embed_desc'            => 'Embed the VAT calculator on your own website',
        'history'               => 'VAT Rate History',
        'history_desc'          => 'Complete history of VAT rate changes across all EU countries',
        'standard_rate_label'   => 'Standard Rate:',
        'overview_guide'        => ':country VAT Overview & Guide',
        'country_calculator'    => ':country VAT Calculator',
        'validate_numbers'      => 'Validate :country VAT Numbers',
        'standalone_calculator' => ':country Standalone Calculator',
        'llms_txt'              => 'llms.txt - AI/LLM Documentation',
        'llms_txt_desc'         => 'Structured data for AI agents and language models',
        'full_vat_rates'        => 'Full VAT Rates (Markdown)',
        'full_vat_rates_desc'   => 'Complete Markdown table of all EU VAT rates',
        'json_api'              => 'JSON API for AI/RAG',
        'json_api_desc'         => 'JSON endpoint optimized for RAG and LLM context retrieval',
        'xml_sitemap'           => 'XML Sitemap',
        'xml_sitemap_desc'      => 'Machine-readable sitemap for search engines',
        'vies_validation'       => 'EU VIES VAT Validation',
        'vies_desc'             => 'Official European Commission VAT number verification',
        'europe_guide'          => 'Your Europe - VAT Guide',
        'europe_guide_desc'     => 'Official EU guide on VAT for businesses',
        'pdf_tools'             => 'PDF Tools by BusinessPress',
        'pdf_tools_desc'        => 'Free online PDF tools for invoices and documents',
        'github_repo'           => 'GitHub Repository',
        'github_desc'           => 'Open source code for EU VAT Info',
        'about_title'           => 'About EU VAT Info',
        'about_p1'              => 'EU VAT Info provides comprehensive, daily-updated VAT information for all 27 European Union member states. Use our :calculator_link to compute VAT amounts instantly, explore the :map_link to visualize rates across Europe, or browse all 27 country pages below for detailed VAT guides and validators.',
        'about_p2'              => 'Each country page includes a detailed VAT guide, a country-specific calculator with custom rate support, and a VIES-powered VAT number validator. Developers and AI agents can access our data via the :llms_link standard or the :api_link.',
        'about_llms_label'      => 'llms.txt',
        'about_api_label'       => 'JSON API',
    ],

    // ── 404 Page ────────────────────────────────────────────────────────
    'error_404' => [
        'title'             => 'Page Not Found',
        'meta_title'        => 'Page Not Found - EU VAT Info',
        'meta_desc'         => 'The page you were looking for could not be found. Browse EU VAT rates, calculators, and country guides for all 27 EU member states.',
        'heading'           => 'Oops! Page Not Found',
        'message'           => 'The page you\'re looking for doesn\'t exist or has been moved. Don\'t worry — there\'s plenty of useful VAT information to explore.',
        'back'              => 'Go Back Home',
        'search_hint'       => 'Try one of these instead:',
        'popular_tools'     => 'VAT Tools',
        'popular_countries' => 'Popular EU Countries',
        'all_countries_cta' => 'View All 27 EU Countries',
        'explore_resources' => 'Resources & Data',
        'tool_calculator'      => 'VAT Calculator',
        'tool_calculator_desc' => 'Calculate VAT instantly for any EU country with standard or custom rates.',
        'tool_map'             => 'Interactive VAT Map',
        'tool_map_desc'        => 'Visualize and compare standard VAT rates across all EU member states.',
        'tool_history'         => 'VAT Rate History',
        'tool_history_desc'    => 'Track VAT rate changes across Europe from 2000 onwards.',
        'tool_validator'       => 'VAT Number Validator',
        'tool_validator_desc'  => 'Verify EU VAT numbers via the official VIES system.',
        'resource_api'         => 'VAT Rates API (JSON)',
        'resource_api_desc'    => 'Access EU VAT rate data via our JSON endpoint.',
        'resource_llms'        => 'llms.txt - AI/LLM Data',
        'resource_llms_desc'   => 'Structured VAT data for AI agents and language models.',
        'resource_sitemap'     => 'Full Sitemap',
        'resource_sitemap_desc' => 'Browse every page on EU VAT Info.',
        'resource_github'      => 'GitHub Repository',
        'resource_github_desc' => 'Open-source code behind EU VAT Info.',
    ],

    // ── Bottom Navigation ───────────────────────────────────────────────
    'bottom_nav' => [
        'home'       => 'Home',
        'calculator' => 'Calculator',
        'map'        => 'Map',
        'history'    => 'History',
    ],

    // ── Country Stats ───────────────────────────────────────────────────
    'stats' => [
        'standard_rate'    => 'Standard Rate',
        'reduced_rate'     => 'Reduced Rate',
        'super_reduced'    => 'Super Reduced',
        'parking_rate'     => 'Parking Rate',
        'eu_rank'          => 'EU Rank',
        'currency'         => 'Currency',
        'last_updated'     => 'Last Updated',
        'see_history'      => 'See VAT history',
    ],

    // ── Useful Links ────────────────────────────────────────────────────
    'useful_links' => [
        'title'          => 'Useful Resources',
        'eu_commission'  => 'European Commission – VAT',
        'vies_service'   => 'VIES VAT Validation',
        'your_europe'    => 'Your Europe – VAT',
        'tax_authority'  => 'National Tax Authority',
    ],

    // ── Validator ───────────────────────────────────────────────────────
    'validator' => [
        'title'           => 'VAT Number Validator',
        'subtitle'        => 'Validate EU VAT numbers via the VIES system',
        'enter_number'    => 'Enter VAT Number',
        'validate'        => 'Validate',
        'valid'           => 'Valid',
        'invalid'         => 'Invalid',
        'company_name'    => 'Company Name',
        'company_address' => 'Company Address',
        'request_date'    => 'Request Date',
    ],

    // ── Language Switcher ───────────────────────────────────────────────
    'language_switcher' => [
        'label'    => 'Language',
        'current'  => 'Current language: :name',
    ],
];
