<?php

/*
|--------------------------------------------------------------------------
| UI Translations – Polish (Polski)
|--------------------------------------------------------------------------
| All translatable static strings used across blade templates.
| Organised by component / page for easy maintenance.
*/

return [

    // ── Global / Shared ──────────────────────────────────────────────────
    'site_name'           => 'EU VAT Info',
    'home'                => 'Strona główna',
    'all_countries'       => 'Wszystkie kraje',
    'details'             => 'Szczegóły',
    'actions'             => 'Akcje',
    'filters'             => 'Filtry',
    'search'              => 'Szukaj',
    'save'                => 'Zapisz',
    'calculate'           => 'Oblicz',
    'loading'             => 'Ładowanie...',
    'all_rights_reserved' => 'Wszelkie prawa zastrzeżone.',
    'data_updated_daily'  => 'Dane aktualizowane codziennie',
    'country'             => 'Kraj',
    'countries'           => 'Kraje',
    'rate'                => 'Stawka',
    'type'                => 'Typ',
    'language'            => 'Język',
    'back_to_home'        => 'Powrót do strony głównej',

    // ── Navigation ──────────────────────────────────────────────────────
    'nav' => [
        'all_countries'  => 'Wszystkie kraje',
        'vat_calculator' => 'Kalkulator VAT',
        'vat_widget'     => 'Widget VAT',
        'vat_map'        => 'Mapa VAT',
        'vat_history'    => 'Historia VAT',
    ],

    // ── Footer ──────────────────────────────────────────────────────────
    'footer' => [
        'description'      => 'Twoje zaufane źródło aktualnych stawek VAT, kalkulacji i informacji o zgodności we wszystkich 27 państwach członkowskich Unii Europejskiej. Aktualizowane codziennie z najnowszymi stawkami.',
        'vat_tools'        => 'Narzędzia VAT',
        'resources'        => 'Zasoby',
        'partner_tools'    => 'Narzędzia partnerów',
        'vat_calculator'   => 'Kalkulator VAT',
        'interactive_map'  => 'Interaktywna mapa VAT',
        'vat_rate_history' => 'Historia stawek VAT',
        'embed_widget'     => 'Widget VAT do osadzenia',
        'sitemap'          => 'Mapa strony',
        'llms_data'        => 'llms.txt - Dane AI/LLM',
        'vat_rates_api'    => 'API stawek VAT (JSON)',
        'xml_sitemap'      => 'Mapa strony XML',
        'pdf_tools'        => 'Narzędzia PDF - BusinessPress',
        'eu_vies'          => 'Walidacja EU VIES',
        'eu_vat_guide'     => 'Przewodnik po VAT w UE',
    ],

    // ── Home Page ───────────────────────────────────────────────────────
    'home_page' => [
        'title'          => 'EU VAT Info - Kalkulator stawek VAT i informacje dla wszystkich krajów UE',
        'meta_desc'      => 'Aktualne stawki VAT dla wszystkich 27 krajów UE. Darmowy kalkulator online, dane historyczne od 2000 roku, alerty o zmianach stawek i przewodniki po zgodności. Aktualizowane codziennie.',
        'heading'        => 'Stawki VAT w',
        'heading_accent' => 'Unii Europejskiej',
        'subtitle'       => 'Aktualne standardowe stawki VAT, stawki obniżone i kalkulator dla wszystkich 27 państw członkowskich UE. Aktualizowane codziennie.',
        'search_placeholder' => 'Wyszukaj kraj...',
        'th_country'     => 'Kraj',
        'th_standard'    => 'Stawka standardowa',
        'th_reduced'     => 'Obniżona',
        'th_actions'     => 'Akcje',
        'view_full'      => 'Zobacz pełny kalkulator i historię',
    ],

    // ── VAT Calculator ──────────────────────────────────────────────────
    'calculator' => [
        'title'              => 'Kalkulator VAT',
        'calculate_instantly' => 'Oblicz stawki VAT natychmiast',
        'amount'             => 'Kwota',
        'vat_rate'           => 'Stawka VAT',
        'custom_rate'        => 'Własna stawka',
        'any_percent'        => 'Dowolny %',
        'enter_custom'       => 'Wprowadź dowolny procent VAT od 0% do 100%',
        'custom_desc'        => 'Wprowadź dowolny procent VAT do obliczeń',
        'calculation_mode'   => 'Tryb obliczania',
        'includes_vat'       => 'Zawiera VAT',
        'excludes_vat'       => 'Bez VAT',
        'extract_vat'        => 'Wyodrębnij VAT z kwoty brutto',
        'add_vat'            => 'Dodaj VAT do kwoty netto',
        'net_amount'         => 'Kwota netto',
        'total_to_pay'       => 'Razem do zapłaty',
    ],

    // ── VAT Map ─────────────────────────────────────────────────────────
    'map' => [
        'title'            => 'Mapa europejskich stawek VAT',
        'subtitle'         => 'Interaktywna mapa pokazująca aktualne standardowe stawki VAT we wszystkich 27 państwach członkowskich UE. Najedź na dowolny kraj, aby zobaczyć jego stawkę, lub kliknij, aby zobaczyć pełne szczegóły i uzyskać dostęp do kalkulatora.',
        'all_rates'        => 'Wszystkie stawki VAT w UE na pierwszy rzut oka',
        'th_country'       => 'Kraj',
        'th_standard'      => 'Standardowa',
        'th_reduced'       => 'Obniżona',
        'th_super_reduced' => 'Super obniżona',
        'th_actions'       => 'Akcje',
        'calculator_link'  => 'Kalkulator',
        'understanding'    => 'Zrozumienie stawek VAT w UE',
        'understanding_desc' => 'UE wymaga od państw członkowskich stosowania standardowej stawki VAT wynoszącej co najmniej 15%. Stawki wahają się od 17% (Luksemburg) do 27% (Węgry).',
        'standard_range'   => 'Stawki standardowe: 17% – 27%',
        'reduced_essentials' => 'Stawki obniżone na artykuły pierwszej potrzeby',
        'special_schemes'  => 'Specjalne systemy dla terytoriów',
        'using_calculator' => 'Korzystanie z kalkulatora VAT',
        'using_calc_desc'  => 'Kliknij dowolny kraj na mapie powyżej lub skorzystaj z tabeli, aby uzyskać dostęp do narzędzi VAT:',
        'calc_inclusive'   => 'Oblicz VAT brutto/netto',
        'view_rate_types'  => 'Zobacz wszystkie obowiązujące typy stawek',
        'validate_vat'     => 'Zweryfikuj numery VAT przez VIES',
    ],

    // ── VAT History / Changes ───────────────────────────────────────────
    'history' => [
        'title'            => 'Historia zmian stawek VAT',
        'meta_title'       => 'Historia zmian stawek VAT - Kraje UE | EU VAT Info',
        'meta_desc'        => 'Pełna historia zmian stawek VAT we wszystkich krajach UE od 2000 roku. Śledź zmiany stawek standardowych i obniżonych ze wskaźnikami stabilności krajów.',
        'subtitle'         => 'Śledź wszystkie zmiany stawek VAT w krajach UE na przestrzeni ostatniej dekady',
        'stability_title'  => 'Wskaźniki stabilności krajów',
        'stability_desc'   => 'Kraje z mniejszą liczbą zmian stawek VAT wskazują na bardziej stabilne środowisko podatkowe',
        'changes'          => 'zmiany',
        'excellent'        => 'Doskonała',
        'good'             => 'Dobra',
        'moderate'         => 'Umiarkowana',
        'frequent'         => 'Częsta',
        'all_countries'    => 'Wszystkie kraje',
        'rate_type'        => 'Typ stawki',
        'all_types'        => 'Wszystkie typy',
        'standard_rate'    => 'Stawka standardowa',
        'reduced_rate'     => 'Stawka obniżona',
        'super_reduced_rate' => 'Stawka super obniżona',
        'parking_rate'     => 'Stawka parkingowa',
        'all_changes'      => 'Wszystkie zmiany (ostatnie 10 lat)',
        'effective_from'   => 'obowiązuje od :date',
        'valid_until'      => 'Ważne do: :date',
        'currently_active' => 'Aktualnie obowiązuje',
        'view_calculator'  => 'Zobacz kalkulator',
        'no_changes'       => 'Nie znaleziono zmian stawek VAT pasujących do wybranych kryteriów',
    ],

    // ── VAT Rate Changes Widget ─────────────────────────────────────────
    'rate_changes' => [
        'title'            => 'Zmiany stawek VAT',
        'upcoming'         => 'Nadchodzące zmiany',
        'recent'           => 'Ostatnie zmiany',
        'no_changes'       => 'Brak ostatnich lub nadchodzących zmian stawek VAT',
        'full_history'     => 'Pełna historia VAT',
        'explore_map'      => 'Odkryj mapę VAT',
    ],

    // ── Country Page ────────────────────────────────────────────────────
    'country_page' => [
        'vat_rates'       => 'Stawki VAT',
        'standard_rate'   => 'Stawka standardowa',
        'reduced_rate'    => 'Stawka obniżona',
        'super_reduced'   => 'Stawka super obniżona',
        'parking_rate'    => 'Stawka parkingowa',
        'zero_rate'       => 'Stawka zerowa',
        'vat_calculator'  => 'Kalkulator VAT',
        'vat_validator'   => 'Walidator VAT',
        'vat_history'     => 'Historia VAT',
        'vat_guide'       => 'Przewodnik po VAT',
        'related'         => 'Powiązane kraje',
    ],

    // ── Breadcrumbs ─────────────────────────────────────────────────────
    'breadcrumbs' => [
        'home'           => 'Strona główna',
        'vat_calculator' => 'Kalkulator VAT',
        'vat_map'        => 'Mapa VAT',
        'vat_changelog'  => 'Rejestr zmian VAT',
        'sitemap'        => 'Mapa strony',
    ],

    // ── HTML Sitemap ────────────────────────────────────────────────────
    'sitemap' => [
        'title'           => 'Mapa strony',
        'subtitle'        => 'Przeglądaj wszystkie strony EU VAT Info. Znajdź kalkulatory VAT, przewodniki po krajach, walidatory stawek i narzędzia dla wszystkich 27 państw członkowskich Unii Europejskiej.',
        'main_pages'      => 'Strony główne',
        'api_data'        => 'API i dane',
        'country_pages'   => 'Strony krajów',
        'home_all'        => 'Strona główna - Wszystkie kraje UE',
        'home_desc'       => 'Przegląd stawek VAT dla wszystkich 27 państw członkowskich UE',
        'calculator'      => 'Kalkulator VAT',
        'calculator_desc' => 'Oblicz kwoty VAT dla dowolnego kraju UE z własnymi stawkami',
        'map'             => 'Interaktywna mapa VAT',
        'map_desc'        => 'Wizualna mapa cieplna standardowych stawek VAT w Europie',
        'embed'           => 'Widget VAT do osadzenia',
        'embed_desc'      => 'Osadź kalkulator VAT na swojej stronie internetowej',
        'history'               => 'Historia stawek VAT',
        'history_desc'          => 'Pełna historia zmian stawek VAT we wszystkich krajach UE',
        'heading'               => 'Mapa',
        'heading_accent'        => 'Strony',
        'meta_title'            => 'Mapa strony HTML – Wszystkie strony VAT UE | EU VAT Info',
        'meta_desc'             => 'Pełna mapa strony EU VAT Info. Przeglądaj wszystkie strony, w tym kalkulatory VAT, przewodniki po krajach, walidatory i narzędzia dla wszystkich 27 państw członkowskich UE.',
        'schema_name'           => 'EU VAT Info – Pełna mapa strony',
        'schema_desc'           => 'Przeglądaj wszystkie strony EU VAT Info, w tym kalkulatory VAT dla poszczególnych krajów, walidatory, przewodniki i narzędzia.',
        'external_resources'    => 'Zasoby zewnętrzne',
        'all_country_pages'     => 'Wszystkie strony VAT dla krajów UE',
        'country_pages_desc'    => 'Przeglądaj informacje o VAT, kalkulatory i walidatory dla każdego państwa członkowskiego UE.',
        'standard_rate_label'   => 'Stawka podstawowa:',
        'overview_guide'        => ':country – Przegląd i przewodnik VAT',
        'country_calculator'    => ':country – Kalkulator VAT',
        'validate_numbers'      => 'Walidacja numerów VAT :country',
        'standalone_calculator' => ':country – Samodzielny kalkulator',
        'llms_txt'              => 'llms.txt – Dokumentacja AI/LLM',
        'llms_txt_desc'         => 'Ustrukturyzowane dane dla agentów AI i modeli językowych',
        'full_vat_rates'        => 'Wszystkie stawki VAT (Markdown)',
        'full_vat_rates_desc'   => 'Pełna tabela Markdown wszystkich stawek VAT w UE',
        'json_api'              => 'JSON API dla AI/RAG',
        'json_api_desc'         => 'Endpoint JSON zoptymalizowany dla RAG i pobierania kontekstu LLM',
        'xml_sitemap'           => 'XML Sitemap',
        'xml_sitemap_desc'      => 'Mapa strony czytelna maszynowo dla wyszukiwarek',
        'vies_validation'       => 'EU VIES – Walidacja VAT',
        'vies_desc'             => 'Oficjalna weryfikacja numerów VAT Komisji Europejskiej',
        'europe_guide'          => 'Your Europe – Przewodnik VAT',
        'europe_guide_desc'     => 'Oficjalny przewodnik UE po VAT dla firm',
        'pdf_tools'             => 'Narzędzia PDF od BusinessPress',
        'pdf_tools_desc'        => 'Bezpłatne narzędzia PDF online do faktur i dokumentów',
        'github_repo'           => 'GitHub Repository',
        'github_desc'           => 'Kod open source EU VAT Info',
        'about_title'           => 'O EU VAT Info',
        'about_p1'              => 'EU VAT Info zapewnia kompleksowe, codziennie aktualizowane informacje o VAT dla wszystkich 27 państw członkowskich Unii Europejskiej. Skorzystaj z naszego :calculator_link, aby natychmiast obliczać kwoty VAT, przeglądaj :map_link, aby wizualizować stawki w Europie, lub przeszukaj 27 stron krajów poniżej, aby znaleźć szczegółowe przewodniki VAT i walidatory.',
        'about_p2'              => 'Każda strona kraju zawiera szczegółowy przewodnik po VAT, kalkulator specyficzny dla kraju z obsługą niestandardowych stawek oraz walidator numerów VAT oparty na VIES. Deweloperzy i agenci AI mogą uzyskać dostęp do naszych danych za pośrednictwem standardu :llms_link lub :api_link.',
        'about_llms_label'      => 'llms.txt',
        'about_api_label'       => 'JSON API',
    ],

    // ── 404 Page ────────────────────────────────────────────────────────
    'error_404' => [
        'title'             => 'Strona nie znaleziona',
        'meta_title'        => 'Strona nie znaleziona - EU VAT Info',
        'meta_desc'         => 'Szukana strona nie została znaleziona. Przeglądaj stawki VAT, kalkulatory i przewodniki po krajach dla wszystkich 27 państw członkowskich UE.',
        'heading'           => 'Ups! Strona nie znaleziona',
        'message'           => 'Strona, której szukasz, nie istnieje lub została przeniesiona. Nie martw się — jest wiele przydatnych informacji o VAT do odkrycia.',
        'back'              => 'Wróć na stronę główną',
        'search_hint'       => 'Wypróbuj jedno z tych:',
        'popular_tools'     => 'Narzędzia VAT',
        'popular_countries' => 'Popularne kraje UE',
        'all_countries_cta' => 'Zobacz wszystkie 27 krajów UE',
        'explore_resources' => 'Zasoby i dane',
        'tool_calculator'      => 'Kalkulator VAT',
        'tool_calculator_desc' => 'Oblicz VAT natychmiast dla dowolnego kraju UE ze standardowymi lub niestandardowymi stawkami.',
        'tool_map'             => 'Interaktywna mapa VAT',
        'tool_map_desc'        => 'Wizualizuj i porównuj stawki VAT we wszystkich państwach członkowskich UE.',
        'tool_history'         => 'Historia stawek VAT',
        'tool_history_desc'    => 'Śledź zmiany stawek VAT w Europie od 2000 roku.',
        'tool_validator'       => 'Walidator numeru VAT',
        'tool_validator_desc'  => 'Weryfikuj numery VAT UE za pośrednictwem oficjalnego systemu VIES.',
        'resource_api'         => 'API stawek VAT (JSON)',
        'resource_api_desc'    => 'Uzyskaj dostęp do danych stawek VAT UE przez nasz punkt końcowy JSON.',
        'resource_llms'        => 'llms.txt - Dane AI/LLM',
        'resource_llms_desc'   => 'Ustrukturyzowane dane VAT dla agentów AI i modeli językowych.',
        'resource_sitemap'     => 'Pełna mapa witryny',
        'resource_sitemap_desc' => 'Przeglądaj każdą stronę na EU VAT Info.',
        'resource_github'      => 'Repozytorium GitHub',
        'resource_github_desc' => 'Kod open source stojący za EU VAT Info.',
    ],

    // ── Bottom Navigation ───────────────────────────────────────────────
    'bottom_nav' => [
        'home'       => 'Start',
        'calculator' => 'Kalkulator',
        'map'        => 'Mapa',
        'history'    => 'Historia',
    ],

    // ── Country Stats ───────────────────────────────────────────────────
    'stats' => [
        'standard_rate'    => 'Stawka standardowa',
        'reduced_rate'     => 'Stawka obniżona',
        'super_reduced'    => 'Super obniżona',
        'parking_rate'     => 'Stawka parkingowa',
        'eu_rank'          => 'Pozycja w UE',
        'currency'         => 'Waluta',
        'last_updated'     => 'Ostatnia aktualizacja',
    ],

    // ── Useful Links ────────────────────────────────────────────────────
    'useful_links' => [
        'title'          => 'Przydatne zasoby',
        'eu_commission'  => 'Komisja Europejska – VAT',
        'vies_service'   => 'Walidacja VAT VIES',
        'your_europe'    => 'Twoja Europa – VAT',
        'tax_authority'  => 'Krajowa administracja skarbowa',
    ],

    // ── Validator ───────────────────────────────────────────────────────
    'validator' => [
        'title'           => 'Walidator numeru VAT',
        'subtitle'        => 'Zweryfikuj numery VAT UE za pomocą systemu VIES',
        'enter_number'    => 'Wprowadź numer VAT',
        'validate'        => 'Zweryfikuj',
        'valid'           => 'Prawidłowy',
        'invalid'         => 'Nieprawidłowy',
        'company_name'    => 'Nazwa firmy',
        'company_address' => 'Adres firmy',
        'request_date'    => 'Data zapytania',
    ],

    // ── Language Switcher ───────────────────────────────────────────────
    'language_switcher' => [
        'label'    => 'Język',
        'current'  => 'Aktualny język: :name',
    ],
];
