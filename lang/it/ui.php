<?php

/*
|--------------------------------------------------------------------------
| UI Translations – Italian (Italiano)
|--------------------------------------------------------------------------
| All translatable static strings used across blade templates.
| Organised by component / page for easy maintenance.
*/

return [

    // ── Global / Shared ──────────────────────────────────────────────────
    'site_name'           => 'EU VAT Info',
    'home'                => 'Home',
    'all_countries'       => 'Tutti i paesi',
    'details'             => 'Dettagli',
    'actions'             => 'Azioni',
    'filters'             => 'Filtri',
    'search'              => 'Cerca',
    'save'                => 'Salva',
    'calculate'           => 'Calcola',
    'loading'             => 'Caricamento...',
    'all_rights_reserved' => 'Tutti i diritti riservati.',
    'data_updated_daily'  => 'Dati aggiornati quotidianamente',
    'country'             => 'Paese',
    'countries'           => 'Paesi',
    'rate'                => 'Aliquota',
    'type'                => 'Tipo',
    'language'            => 'Lingua',
    'back_to_home'        => 'Torna alla home',

    // ── Navigation ──────────────────────────────────────────────────────
    'nav' => [
        'all_countries'  => 'Tutti i paesi',
        'vat_calculator' => 'Calcolatore IVA',
        'vat_widget'     => 'Widget IVA',
        'vat_map'        => 'Mappa IVA',
        'vat_history'    => 'Storico IVA',
    ],

    // ── Footer ──────────────────────────────────────────────────────────
    'footer' => [
        'description'      => 'La tua fonte affidabile per aliquote IVA aggiornate, calcoli e informazioni sulla conformità in tutti i 27 stati membri dell\'Unione Europea. Aggiornato quotidianamente con le ultime aliquote.',
        'vat_tools'        => 'Strumenti IVA',
        'resources'        => 'Risorse',
        'partner_tools'    => 'Strumenti partner',
        'vat_calculator'   => 'Calcolatore IVA',
        'interactive_map'  => 'Mappa IVA interattiva',
        'vat_rate_history' => 'Storico delle aliquote IVA',
        'embed_widget'     => 'Widget IVA incorporabile',
        'sitemap'          => 'Mappa del sito',
        'llms_data'        => 'llms.txt - Dati per IA/LLM',
        'vat_rates_api'    => 'API aliquote IVA (JSON)',
        'xml_sitemap'      => 'Mappa del sito XML',
        'pdf_tools'        => 'Strumenti PDF - BusinessPress',
        'eu_vies'          => 'Validazione VIES UE',
        'eu_vat_guide'     => 'Guida IVA UE',
    ],

    // ── Home Page ───────────────────────────────────────────────────────
    'home_page' => [
        'title'          => 'EU VAT Info - Calcolatore aliquote IVA e informazioni per tutti i paesi UE',
        'meta_desc'      => 'Aliquote IVA aggiornate per tutti i 27 paesi UE. Calcolatore online gratuito, dati storici dal 2000, avvisi sui cambi di aliquota e guide alla conformità. Aggiornato quotidianamente.',
        'heading'        => 'Aliquote IVA nell\'',
        'heading_accent' => 'Unione Europea',
        'subtitle'       => 'Aliquote IVA standard, aliquote ridotte e calcolatore per tutti i 27 stati membri dell\'UE. Aggiornato quotidianamente.',
        'search_placeholder' => 'Cerca un paese...',
        'th_country'     => 'Paese',
        'th_standard'    => 'Aliquota standard',
        'th_reduced'     => 'Ridotta',
        'th_actions'     => 'Azioni',
        'view_full'      => 'Visualizza calcolatore completo e storico',
    ],

    // ── VAT Calculator ──────────────────────────────────────────────────
    'calculator' => [
        'title'              => 'Calcolatore IVA',
        'calculate_instantly' => 'Calcola le aliquote IVA istantaneamente',
        'amount'             => 'Importo',
        'vat_rate'           => 'Aliquota IVA',
        'custom_rate'        => 'Aliquota personalizzata',
        'any_percent'        => 'Qualsiasi %',
        'enter_custom'       => 'Inserisci qualsiasi percentuale IVA dallo 0% al 100%',
        'custom_desc'        => 'Inserisci qualsiasi percentuale IVA per il tuo calcolo',
        'calculation_mode'   => 'Modalità di calcolo',
        'includes_vat'       => 'IVA inclusa',
        'excludes_vat'       => 'IVA esclusa',
        'extract_vat'        => 'Estrarre l\'IVA dal totale',
        'add_vat'            => 'Aggiungere l\'IVA all\'importo netto',
        'net_amount'         => 'Importo netto',
        'total_to_pay'       => 'Totale da pagare',
    ],

    // ── VAT Map ─────────────────────────────────────────────────────────
    'map' => [
        'title'            => 'Mappa delle aliquote IVA europee',
        'subtitle'         => 'Mappa interattiva che mostra le aliquote IVA standard attuali in tutti i 27 stati membri dell\'UE. Passa il mouse su un paese per visualizzare la sua aliquota, oppure clicca per i dettagli completi e accedere al calcolatore.',
        'all_rates'        => 'Tutte le aliquote IVA UE a colpo d\'occhio',
        'th_country'       => 'Paese',
        'th_standard'      => 'Standard',
        'th_reduced'       => 'Ridotta',
        'th_super_reduced' => 'Super ridotta',
        'th_actions'       => 'Azioni',
        'calculator_link'  => 'Calcolatore',
        'understanding'    => 'Comprendere le aliquote IVA UE',
        'understanding_desc' => 'L\'UE richiede agli stati membri di applicare un\'aliquota IVA standard di almeno il 15%. Le aliquote vanno dal 17% (Lussemburgo) al 27% (Ungheria).',
        'standard_range'   => 'Aliquote standard: 17% – 27%',
        'reduced_essentials' => 'Aliquote ridotte per beni essenziali',
        'special_schemes'  => 'Regimi speciali per i territori',
        'using_calculator' => 'Utilizzo del calcolatore IVA',
        'using_calc_desc'  => 'Clicca su un paese nella mappa qui sopra, oppure usa la tabella per accedere agli strumenti IVA:',
        'calc_inclusive'   => 'Calcolo IVA inclusa/esclusa',
        'view_rate_types'  => 'Visualizza tutti i tipi di aliquota applicabili',
        'validate_vat'     => 'Valida i numeri di partita IVA tramite VIES',
    ],

    // ── VAT History / Changes ───────────────────────────────────────────
    'history' => [
        'title'            => 'Storico delle variazioni delle aliquote IVA',
        'meta_title'       => 'Storico delle variazioni delle aliquote IVA - Paesi UE | EU VAT Info',
        'meta_desc'        => 'Storico completo delle variazioni delle aliquote IVA in tutti i paesi UE dal 2000. Monitora le modifiche delle aliquote standard e ridotte con indicatori di stabilità per paese.',
        'subtitle'         => 'Monitora tutte le modifiche delle aliquote IVA nei paesi UE nell\'ultimo decennio',
        'stability_title'  => 'Indicatori di stabilità per paese',
        'stability_desc'   => 'I paesi con meno variazioni delle aliquote IVA indicano ambienti fiscali più stabili',
        'changes'          => 'variazioni',
        'excellent'        => 'Eccellente',
        'good'             => 'Buono',
        'moderate'         => 'Moderato',
        'frequent'         => 'Frequente',
        'all_countries'    => 'Tutti i paesi',
        'rate_type'        => 'Tipo di aliquota',
        'all_types'        => 'Tutti i tipi',
        'standard_rate'    => 'Aliquota standard',
        'reduced_rate'     => 'Aliquota ridotta',
        'super_reduced_rate' => 'Aliquota super ridotta',
        'parking_rate'     => 'Aliquota di parcheggio',
        'all_changes'      => 'Tutte le variazioni (ultimi 10 anni)',
        'effective_from'   => 'in vigore dal :date',
        'valid_until'      => 'Valido fino al: :date',
        'currently_active' => 'Attualmente in vigore',
        'view_calculator'  => 'Vai al calcolatore',
        'no_changes'       => 'Nessuna variazione delle aliquote IVA trovata corrispondente ai tuoi criteri',
    ],

    // ── VAT Rate Changes Widget ─────────────────────────────────────────
    'rate_changes' => [
        'title'            => 'Variazioni delle aliquote IVA',
        'upcoming'         => 'Variazioni imminenti',
        'recent'           => 'Variazioni recenti',
        'no_changes'       => 'Nessuna variazione recente o imminente delle aliquote IVA',
        'full_history'     => 'Storico completo dell\'IVA',
        'explore_map'      => 'Esplora la mappa IVA',
    ],

    // ── Country Page ────────────────────────────────────────────────────
    'country_page' => [
        'vat_rates'       => 'Aliquote IVA',
        'standard_rate'   => 'Aliquota standard',
        'reduced_rate'    => 'Aliquota ridotta',
        'super_reduced'   => 'Aliquota super ridotta',
        'parking_rate'    => 'Aliquota di parcheggio',
        'zero_rate'       => 'Aliquota zero',
        'vat_calculator'  => 'Calcolatore IVA',
        'vat_validator'   => 'Validatore IVA',
        'vat_history'     => 'Storico IVA',
        'vat_guide'       => 'Guida IVA',
        'related'         => 'Paesi correlati',
    ],

    // ── Breadcrumbs ─────────────────────────────────────────────────────
    'breadcrumbs' => [
        'home'           => 'Home',
        'vat_calculator' => 'Calcolatore IVA',
        'vat_map'        => 'Mappa IVA',
        'vat_changelog'  => 'Registro variazioni IVA',
        'sitemap'        => 'Mappa del sito',
    ],

    // ── HTML Sitemap ────────────────────────────────────────────────────
    'sitemap' => [
        'title'           => 'Mappa del sito',
        'subtitle'        => 'Esplora tutte le pagine di EU VAT Info. Trova calcolatori IVA, guide per paese, validatori di aliquote e strumenti per tutti i 27 stati membri dell\'Unione Europea.',
        'main_pages'      => 'Pagine principali',
        'api_data'        => 'API e dati',
        'country_pages'   => 'Pagine per paese',
        'home_all'        => 'Home - Tutti i paesi UE',
        'home_desc'       => 'Panoramica delle aliquote IVA per tutti i 27 stati membri dell\'UE',
        'calculator'      => 'Calcolatore IVA',
        'calculator_desc' => 'Calcola gli importi IVA per qualsiasi paese UE con aliquote personalizzate',
        'map'             => 'Mappa IVA interattiva',
        'map_desc'        => 'Mappa termica visiva delle aliquote IVA standard in Europa',
        'embed'           => 'Widget IVA incorporabile',
        'embed_desc'      => 'Incorpora il calcolatore IVA nel tuo sito web',
        'history'               => 'Storico delle aliquote IVA',
        'history_desc'          => 'Storico completo delle variazioni delle aliquote IVA in tutti i paesi UE',
        'heading'               => 'Mappa del',
        'heading_accent'        => 'Sito',
        'meta_title'            => 'Mappa del sito HTML – Tutte le pagine IVA UE | EU VAT Info',
        'meta_desc'             => 'Mappa del sito completa di EU VAT Info. Sfoglia tutte le pagine, tra cui calcolatori IVA, guide per paese, validatori e strumenti per tutti i 27 stati membri dell\'UE.',
        'schema_name'           => 'EU VAT Info – Mappa del sito completa',
        'schema_desc'           => 'Sfoglia tutte le pagine di EU VAT Info, inclusi calcolatori IVA per paese, validatori, guide e strumenti.',
        'external_resources'    => 'Risorse esterne',
        'all_country_pages'     => 'Tutte le pagine IVA per paese UE',
        'country_pages_desc'    => 'Sfoglia informazioni IVA, calcolatori e validatori per ogni stato membro dell\'UE.',
        'standard_rate_label'   => 'Aliquota ordinaria:',
        'overview_guide'        => ':country – Panoramica e guida IVA',
        'country_calculator'    => ':country – Calcolatore IVA',
        'validate_numbers'      => 'Validare numeri IVA :country',
        'standalone_calculator' => ':country – Calcolatore autonomo',
        'llms_txt'              => 'llms.txt – Documentazione IA/LLM',
        'llms_txt_desc'         => 'Dati strutturati per agenti IA e modelli linguistici',
        'full_vat_rates'        => 'Tutte le aliquote IVA (Markdown)',
        'full_vat_rates_desc'   => 'Tabella Markdown completa di tutte le aliquote IVA dell\'UE',
        'json_api'              => 'API JSON per IA/RAG',
        'json_api_desc'         => 'Endpoint JSON ottimizzato per RAG e recupero contesto LLM',
        'xml_sitemap'           => 'XML Sitemap',
        'xml_sitemap_desc'      => 'Mappa del sito leggibile dalle macchine per i motori di ricerca',
        'vies_validation'       => 'Validazione IVA VIES UE',
        'vies_desc'             => 'Verifica ufficiale dei numeri di partita IVA della Commissione Europea',
        'europe_guide'          => 'Your Europe – Guida IVA',
        'europe_guide_desc'     => 'Guida ufficiale UE sull\'IVA per le imprese',
        'pdf_tools'             => 'Strumenti PDF di BusinessPress',
        'pdf_tools_desc'        => 'Strumenti PDF online gratuiti per fatture e documenti',
        'github_repo'           => 'GitHub Repository',
        'github_desc'           => 'Codice open source di EU VAT Info',
        'about_title'           => 'Informazioni su EU VAT Info',
        'about_p1'              => 'EU VAT Info fornisce informazioni IVA complete e aggiornate quotidianamente per tutti i 27 stati membri dell\'Unione Europea. Usa il nostro :calculator_link per calcolare gli importi IVA istantaneamente, esplora la :map_link per visualizzare le aliquote in Europa, o sfoglia le 27 pagine paese qui sotto per guide IVA dettagliate e validatori.',
        'about_p2'              => 'Ogni pagina paese include una guida IVA dettagliata, un calcolatore specifico per paese con supporto aliquote personalizzate, e un validatore di numeri IVA basato su VIES. Sviluppatori e agenti IA possono accedere ai nostri dati tramite lo standard :llms_link o l\':api_link.',
        'about_llms_label'      => 'llms.txt',
        'about_api_label'       => 'JSON API',
    ],

    // ── 404 Page ────────────────────────────────────────────────────────
    'error_404' => [
        'title'             => 'Pagina non trovata',
        'meta_title'        => 'Pagina non trovata - EU VAT Info',
        'meta_desc'         => 'La pagina che stavi cercando non è stata trovata. Esplora aliquote IVA, calcolatori e guide paese per tutti i 27 Stati membri dell\'UE.',
        'heading'           => 'Ops! Pagina non trovata',
        'message'           => 'La pagina che cerchi non esiste o è stata spostata. Non preoccuparti — ci sono molte informazioni utili sull\'IVA da esplorare.',
        'back'              => 'Torna alla home',
        'search_hint'       => 'Prova uno di questi:',
        'popular_tools'     => 'Strumenti IVA',
        'popular_countries' => 'Paesi UE popolari',
        'all_countries_cta' => 'Visualizza tutti i 27 paesi UE',
        'explore_resources' => 'Risorse e dati',
        'tool_calculator'      => 'Calcolatore IVA',
        'tool_calculator_desc' => 'Calcola l\'IVA istantaneamente per qualsiasi paese UE con aliquote standard o personalizzate.',
        'tool_map'             => 'Mappa interattiva IVA',
        'tool_map_desc'        => 'Visualizza e confronta le aliquote IVA in tutti gli Stati membri dell\'UE.',
        'tool_history'         => 'Storico aliquote IVA',
        'tool_history_desc'    => 'Segui i cambiamenti delle aliquote IVA in Europa dal 2000.',
        'tool_validator'       => 'Validatore partita IVA',
        'tool_validator_desc'  => 'Verifica le partite IVA UE tramite il sistema VIES ufficiale.',
        'resource_api'         => 'API aliquote IVA (JSON)',
        'resource_api_desc'    => 'Accedi ai dati delle aliquote IVA UE tramite il nostro endpoint JSON.',
        'resource_llms'        => 'llms.txt - Dati IA/LLM',
        'resource_llms_desc'   => 'Dati IVA strutturati per agenti IA e modelli linguistici.',
        'resource_sitemap'     => 'Mappa del sito completa',
        'resource_sitemap_desc' => 'Esplora ogni pagina su EU VAT Info.',
        'resource_github'      => 'Repository GitHub',
        'resource_github_desc' => 'Codice open source di EU VAT Info.',
    ],

    // ── Bottom Navigation ───────────────────────────────────────────────
    'bottom_nav' => [
        'home'       => 'Home',
        'calculator' => 'Calcolatore',
        'map'        => 'Mappa',
        'history'    => 'Storico',
    ],

    // ── Country Stats ───────────────────────────────────────────────────
    'stats' => [
        'standard_rate'    => 'Aliquota standard',
        'reduced_rate'     => 'Aliquota ridotta',
        'super_reduced'    => 'Super ridotta',
        'parking_rate'     => 'Aliquota di parcheggio',
        'eu_rank'          => 'Posizione UE',
        'currency'         => 'Valuta',
        'last_updated'     => 'Ultimo aggiornamento',
    ],

    // ── Useful Links ────────────────────────────────────────────────────
    'useful_links' => [
        'title'          => 'Risorse utili',
        'eu_commission'  => 'Commissione Europea – IVA',
        'vies_service'   => 'Validazione IVA VIES',
        'your_europe'    => 'La tua Europa – IVA',
        'tax_authority'  => 'Autorità fiscale nazionale',
    ],

    // ── Validator ───────────────────────────────────────────────────────
    'validator' => [
        'title'           => 'Validatore partita IVA',
        'subtitle'        => 'Valida i numeri di partita IVA UE tramite il sistema VIES',
        'enter_number'    => 'Inserisci il numero di partita IVA',
        'validate'        => 'Valida',
        'valid'           => 'Valido',
        'invalid'         => 'Non valido',
        'company_name'    => 'Ragione sociale',
        'company_address' => 'Indirizzo dell\'azienda',
        'request_date'    => 'Data della richiesta',
    ],

    // ── Language Switcher ───────────────────────────────────────────────
    'language_switcher' => [
        'label'    => 'Lingua',
        'current'  => 'Lingua corrente: :name',
    ],
];
