<?php

/*
|--------------------------------------------------------------------------
| UI Translations – French
|--------------------------------------------------------------------------
| All translatable static strings used across blade templates.
| Organised by component / page for easy maintenance.
*/

return [

    // ── Global / Shared ──────────────────────────────────────────────────
    'site_name'           => 'EU VAT Info',
    'home'                => 'Accueil',
    'all_countries'       => 'Tous les pays',
    'details'             => 'Détails',
    'actions'             => 'Actions',
    'filters'             => 'Filtres',
    'search'              => 'Rechercher',
    'save'                => 'Enregistrer',
    'calculate'           => 'Calculer',
    'loading'             => 'Chargement...',
    'all_rights_reserved' => 'Tous droits réservés.',
    'data_updated_daily'  => 'Données mises à jour quotidiennement',
    'country'             => 'Pays',
    'countries'           => 'Pays',
    'rate'                => 'Taux',
    'type'                => 'Type',
    'language'            => 'Langue',
    'back_to_home'        => 'Retour à l\'accueil',

    // ── Navigation ──────────────────────────────────────────────────────
    'nav' => [
        'all_countries'  => 'Tous les pays',
        'vat_calculator' => 'Calculateur de TVA',
        'vat_widget'     => 'Widget TVA',
        'vat_map'        => 'Carte de la TVA',
        'vat_history'    => 'Historique de la TVA',
    ],

    // ── Footer ──────────────────────────────────────────────────────────
    'footer' => [
        'description'      => 'Votre source de confiance pour les taux de TVA actuels, les calculs et les informations de conformité dans les 27 États membres de l\'Union européenne. Mis à jour quotidiennement avec les derniers taux.',
        'vat_tools'        => 'Outils TVA',
        'resources'        => 'Ressources',
        'partner_tools'    => 'Outils partenaires',
        'vat_calculator'   => 'Calculateur de TVA',
        'interactive_map'  => 'Carte interactive de la TVA',
        'vat_rate_history' => 'Historique des taux de TVA',
        'embed_widget'     => 'Widget TVA intégrable',
        'sitemap'          => 'Plan du site',
        'llms_data'        => 'llms.txt - Données IA/LLM',
        'vat_rates_api'    => 'API des taux de TVA (JSON)',
        'xml_sitemap'      => 'Plan du site XML',
        'pdf_tools'        => 'Outils PDF - BusinessPress',
        'eu_vies'          => 'Validation VIES de l\'UE',
        'eu_vat_guide'     => 'Guide TVA de l\'UE',
    ],

    // ── Home Page ───────────────────────────────────────────────────────
    'home_page' => [
        'title'          => 'EU VAT Info - Calculateur de taux de TVA et informations pour tous les pays de l\'UE',
        'meta_desc'      => 'Taux de TVA actuels pour les 27 pays de l\'UE. Calculateur en ligne gratuit, données historiques depuis 2000, alertes de changement de taux et guides de conformité. Mis à jour quotidiennement.',
        'heading'        => 'Taux de TVA dans l\'',
        'heading_accent' => 'Union européenne',
        'subtitle'       => 'Taux de TVA standard, taux réduits et calculateur pour les 27 États membres de l\'UE. Mis à jour quotidiennement.',
        'search_placeholder' => 'Rechercher un pays...',
        'th_country'     => 'Pays',
        'th_standard'    => 'Taux standard',
        'th_reduced'     => 'Réduit',
        'th_actions'     => 'Actions',
        'view_full'      => 'Voir le calculateur complet et l\'historique',
    ],

    // ── VAT Calculator ──────────────────────────────────────────────────
    'calculator' => [
        'title'              => 'Calculateur de TVA',
        'calculate_instantly' => 'Calculez les taux de TVA instantanément',
        'amount'             => 'Montant',
        'vat_rate'           => 'Taux de TVA',
        'custom_rate'        => 'Taux personnalisé',
        'any_percent'        => 'N\'importe quel %',
        'enter_custom'       => 'Entrez un pourcentage de TVA de 0 % à 100 %',
        'custom_desc'        => 'Entrez un pourcentage de TVA pour votre calcul',
        'calculation_mode'   => 'Mode de calcul',
        'includes_vat'       => 'TVA incluse',
        'excludes_vat'       => 'Hors TVA',
        'extract_vat'        => 'Extraire la TVA du total',
        'add_vat'            => 'Ajouter la TVA au montant net',
        'net_amount'         => 'Montant net',
        'total_to_pay'       => 'Total à payer',
    ],

    // ── VAT Map ─────────────────────────────────────────────────────────
    'map' => [
        'title'            => 'Carte des taux de TVA européens',
        'subtitle'         => 'Carte interactive affichant les taux de TVA standard actuels dans les 27 États membres de l\'UE. Survolez un pays pour prévisualiser son taux, ou cliquez pour voir tous les détails et accéder au calculateur.',
        'all_rates'        => 'Tous les taux de TVA de l\'UE en un coup d\'œil',
        'th_country'       => 'Pays',
        'th_standard'      => 'Standard',
        'th_reduced'       => 'Réduit',
        'th_super_reduced' => 'Super réduit',
        'th_actions'       => 'Actions',
        'calculator_link'  => 'Calculateur',
        'understanding'    => 'Comprendre les taux de TVA de l\'UE',
        'understanding_desc' => 'L\'UE exige que les États membres appliquent un taux de TVA standard d\'au moins 15 %. Les taux varient de 17 % (Luxembourg) à 27 % (Hongrie).',
        'standard_range'   => 'Taux standard : 17 % – 27 %',
        'reduced_essentials' => 'Taux réduits pour les produits de première nécessité',
        'special_schemes'  => 'Régimes spéciaux pour les territoires',
        'using_calculator' => 'Utiliser le calculateur de TVA',
        'using_calc_desc'  => 'Cliquez sur un pays sur la carte ci-dessus ou utilisez le tableau pour accéder aux outils TVA dédiés :',
        'calc_inclusive'   => 'Calculer la TVA incluse/exclue',
        'view_rate_types'  => 'Voir tous les types de taux applicables',
        'validate_vat'     => 'Valider les numéros de TVA via VIES',
    ],

    // ── VAT History / Changes ───────────────────────────────────────────
    'history' => [
        'title'            => 'Historique des changements de taux de TVA',
        'meta_title'       => 'Historique des changements de taux de TVA - Pays de l\'UE | EU VAT Info',
        'meta_desc'        => 'Historique complet des changements de taux de TVA dans tous les pays de l\'UE depuis 2000. Suivez les modifications des taux standard et réduits avec les indicateurs de stabilité par pays.',
        'subtitle'         => 'Suivez toutes les modifications de taux de TVA dans les pays de l\'UE au cours de la dernière décennie',
        'stability_title'  => 'Indicateurs de stabilité par pays',
        'stability_desc'   => 'Les pays avec moins de changements de taux de TVA indiquent des environnements fiscaux plus stables',
        'changes'          => 'changements',
        'excellent'        => 'Excellent',
        'good'             => 'Bon',
        'moderate'         => 'Modéré',
        'frequent'         => 'Fréquent',
        'all_countries'    => 'Tous les pays',
        'rate_type'        => 'Type de taux',
        'all_types'        => 'Tous les types',
        'standard_rate'    => 'Taux standard',
        'reduced_rate'     => 'Taux réduit',
        'super_reduced_rate' => 'Taux super réduit',
        'parking_rate'     => 'Taux de stationnement',
        'all_changes'      => 'Tous les changements (10 dernières années)',
        'effective_from'   => 'en vigueur à partir du :date',
        'valid_until'      => 'Valable jusqu\'au : :date',
        'currently_active' => 'Actuellement en vigueur',
        'view_calculator'  => 'Voir le calculateur',
        'no_changes'       => 'Aucun changement de taux de TVA ne correspond à vos critères',
    ],

    // ── VAT Rate Changes Widget ─────────────────────────────────────────
    'rate_changes' => [
        'title'            => 'Changements de taux de TVA',
        'upcoming'         => 'Changements à venir',
        'recent'           => 'Changements récents',
        'no_changes'       => 'Aucun changement de taux de TVA récent ou à venir',
        'full_history'     => 'Historique complet de la TVA',
        'explore_map'      => 'Explorer la carte TVA',
    ],

    // ── Country Page ────────────────────────────────────────────────────
    'country_page' => [
        'vat_rates'       => 'Taux de TVA',
        'standard_rate'   => 'Taux standard',
        'reduced_rate'    => 'Taux réduit',
        'super_reduced'   => 'Taux super réduit',
        'parking_rate'    => 'Taux de stationnement',
        'zero_rate'       => 'Taux zéro',
        'vat_calculator'  => 'Calculateur de TVA',
        'vat_validator'   => 'Validateur de TVA',
        'vat_history'     => 'Historique de la TVA',
        'vat_guide'       => 'Guide TVA',
        'related'         => 'Pays associés',
    ],

    // ── Breadcrumbs ─────────────────────────────────────────────────────
    'breadcrumbs' => [
        'home'           => 'Accueil',
        'vat_calculator' => 'Calculateur de TVA',
        'vat_map'        => 'Carte de la TVA',
        'vat_changelog'  => 'Journal des modifications TVA',
        'sitemap'        => 'Plan du site',
    ],

    // ── HTML Sitemap ────────────────────────────────────────────────────
    'sitemap' => [
        'title'           => 'Plan du site',
        'subtitle'        => 'Explorez toutes les pages d\'EU VAT Info. Trouvez des calculateurs de TVA, des guides par pays, des validateurs de taux et des outils pour les 27 États membres de l\'Union européenne.',
        'main_pages'      => 'Pages principales',
        'api_data'        => 'API et données',
        'country_pages'   => 'Pages par pays',
        'home_all'        => 'Accueil - Tous les pays de l\'UE',
        'home_desc'       => 'Aperçu des taux de TVA pour les 27 États membres de l\'UE',
        'calculator'      => 'Calculateur de TVA',
        'calculator_desc' => 'Calculez les montants de TVA pour n\'importe quel pays de l\'UE avec des taux personnalisés',
        'map'             => 'Carte interactive de la TVA',
        'map_desc'        => 'Carte thermique visuelle des taux de TVA standard à travers l\'Europe',
        'embed'           => 'Widget TVA intégrable',
        'embed_desc'      => 'Intégrez le calculateur de TVA sur votre propre site web',
        'history'               => 'Historique des taux de TVA',
        'history_desc'          => 'Historique complet des changements de taux de TVA dans tous les pays de l\'UE',
        'heading'               => 'Plan du',
        'heading_accent'        => 'Site',
        'meta_title'            => 'Plan du site HTML – Toutes les pages TVA UE | EU VAT Info',
        'meta_desc'             => 'Plan du site complet d\'EU VAT Info. Parcourez toutes les pages, y compris les calculateurs de TVA, guides par pays, validateurs et outils pour les 27 États membres de l\'UE.',
        'schema_name'           => 'EU VAT Info – Plan du site complet',
        'schema_desc'           => 'Parcourez toutes les pages d\'EU VAT Info, y compris les calculateurs de TVA par pays, les validateurs, les guides et les outils.',
        'external_resources'    => 'Ressources externes',
        'all_country_pages'     => 'Toutes les pages TVA par pays de l\'UE',
        'country_pages_desc'    => 'Parcourez les informations TVA, calculateurs et validateurs pour chaque État membre de l\'UE.',
        'standard_rate_label'   => 'Taux normal :',
        'overview_guide'        => ':country – Aperçu & guide TVA',
        'country_calculator'    => ':country – Calculateur de TVA',
        'validate_numbers'      => 'Valider les numéros de TVA :country',
        'standalone_calculator' => ':country – Calculateur autonome',
        'llms_txt'              => 'llms.txt – Documentation IA/LLM',
        'llms_txt_desc'         => 'Données structurées pour les agents IA et les modèles de langage',
        'full_vat_rates'        => 'Tous les taux de TVA (Markdown)',
        'full_vat_rates_desc'   => 'Tableau Markdown complet de tous les taux de TVA de l\'UE',
        'json_api'              => 'API JSON pour IA/RAG',
        'json_api_desc'         => 'Point d\'accès JSON optimisé pour le RAG et la récupération de contexte LLM',
        'xml_sitemap'           => 'XML Sitemap',
        'xml_sitemap_desc'      => 'Plan du site lisible par les machines pour les moteurs de recherche',
        'vies_validation'       => 'Validation TVA VIES UE',
        'vies_desc'             => 'Vérification officielle des numéros de TVA par la Commission européenne',
        'europe_guide'          => 'Your Europe – Guide TVA',
        'europe_guide_desc'     => 'Guide officiel de l\'UE sur la TVA pour les entreprises',
        'pdf_tools'             => 'Outils PDF par BusinessPress',
        'pdf_tools_desc'        => 'Outils PDF en ligne gratuits pour les factures et documents',
        'github_repo'           => 'GitHub Repository',
        'github_desc'           => 'Code open source d\'EU VAT Info',
        'about_title'           => 'À propos d\'EU VAT Info',
        'about_p1'              => 'EU VAT Info fournit des informations TVA complètes et mises à jour quotidiennement pour les 27 États membres de l\'Union européenne. Utilisez notre :calculator_link pour calculer les montants de TVA instantanément, explorez la :map_link pour visualiser les taux à travers l\'Europe, ou parcourez les 27 pages pays ci-dessous pour des guides TVA détaillés et des validateurs.',
        'about_p2'              => 'Chaque page pays comprend un guide TVA détaillé, un calculateur spécifique au pays avec support de taux personnalisés, et un validateur de numéros de TVA alimenté par VIES. Les développeurs et agents IA peuvent accéder à nos données via le standard :llms_link ou l\':api_link.',
        'about_llms_label'      => 'llms.txt',
        'about_api_label'       => 'JSON API',
    ],

    // ── 404 Page ────────────────────────────────────────────────────────
    'error_404' => [
        'title'             => 'Page non trouvée',
        'meta_title'        => 'Page non trouvée - EU VAT Info',
        'meta_desc'         => 'La page que vous cherchiez est introuvable. Parcourez les taux de TVA, calculateurs et guides pays pour les 27 États membres de l\'UE.',
        'heading'           => 'Oups ! Page non trouvée',
        'message'           => 'La page que vous cherchez n\'existe pas ou a été déplacée. Pas d\'inquiétude — il y a plein d\'informations utiles sur la TVA à découvrir.',
        'back'              => 'Retour à l\'accueil',
        'search_hint'       => 'Essayez plutôt l\'un de ceux-ci :',
        'popular_tools'     => 'Outils TVA',
        'popular_countries' => 'Pays UE populaires',
        'all_countries_cta' => 'Voir les 27 pays de l\'UE',
        'explore_resources' => 'Ressources & Données',
        'tool_calculator'      => 'Calculateur de TVA',
        'tool_calculator_desc' => 'Calculez la TVA instantanément pour tout pays de l\'UE avec des taux standard ou personnalisés.',
        'tool_map'             => 'Carte interactive de la TVA',
        'tool_map_desc'        => 'Visualisez et comparez les taux de TVA dans tous les États membres de l\'UE.',
        'tool_history'         => 'Historique des taux de TVA',
        'tool_history_desc'    => 'Suivez les changements de taux de TVA en Europe depuis 2000.',
        'tool_validator'       => 'Validateur de numéro de TVA',
        'tool_validator_desc'  => 'Vérifiez les numéros de TVA de l\'UE via le système VIES officiel.',
        'resource_api'         => 'API Taux de TVA (JSON)',
        'resource_api_desc'    => 'Accédez aux données des taux de TVA de l\'UE via notre point de terminaison JSON.',
        'resource_llms'        => 'llms.txt - Données IA/LLM',
        'resource_llms_desc'   => 'Données TVA structurées pour agents IA et modèles de langage.',
        'resource_sitemap'     => 'Plan du site complet',
        'resource_sitemap_desc' => 'Parcourez chaque page sur EU VAT Info.',
        'resource_github'      => 'Dépôt GitHub',
        'resource_github_desc' => 'Code open source derrière EU VAT Info.',
    ],

    // ── Bottom Navigation ───────────────────────────────────────────────
    'bottom_nav' => [
        'home'       => 'Accueil',
        'calculator' => 'Calculateur',
        'map'        => 'Carte',
        'history'    => 'Historique',
    ],

    // ── Country Stats ───────────────────────────────────────────────────
    'stats' => [
        'standard_rate'    => 'Taux standard',
        'reduced_rate'     => 'Taux réduit',
        'super_reduced'    => 'Taux super réduit',
        'parking_rate'     => 'Taux de stationnement',
        'eu_rank'          => 'Classement UE',
        'currency'         => 'Devise',
        'last_updated'     => 'Dernière mise à jour',
    ],

    // ── Useful Links ────────────────────────────────────────────────────
    'useful_links' => [
        'title'          => 'Ressources utiles',
        'eu_commission'  => 'Commission européenne – TVA',
        'vies_service'   => 'Validation TVA VIES',
        'your_europe'    => 'Votre Europe – TVA',
        'tax_authority'  => 'Administration fiscale nationale',
    ],

    // ── Validator ───────────────────────────────────────────────────────
    'validator' => [
        'title'           => 'Validateur de numéro de TVA',
        'subtitle'        => 'Validez les numéros de TVA intracommunautaires via le système VIES',
        'enter_number'    => 'Entrez le numéro de TVA',
        'validate'        => 'Valider',
        'valid'           => 'Valide',
        'invalid'         => 'Invalide',
        'company_name'    => 'Raison sociale',
        'company_address' => 'Adresse de l\'entreprise',
        'request_date'    => 'Date de la demande',
    ],

    // ── Language Switcher ───────────────────────────────────────────────
    'language_switcher' => [
        'label'    => 'Langue',
        'current'  => 'Langue actuelle : :name',
    ],
];
