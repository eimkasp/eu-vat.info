<?php

return [
    'api_key' => env('DEEPL_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | All 24 Official EU Languages
    |--------------------------------------------------------------------------
    */
    'supported_languages' => [
        'en' => ['name' => 'English',    'native' => 'English',    'flag' => 'gb', 'deepl_code' => 'EN-GB'],
        'bg' => ['name' => 'Bulgarian',  'native' => 'Български',  'flag' => 'bg', 'deepl_code' => 'BG'],
        'cs' => ['name' => 'Czech',      'native' => 'Čeština',    'flag' => 'cz', 'deepl_code' => 'CS'],
        'da' => ['name' => 'Danish',     'native' => 'Dansk',      'flag' => 'dk', 'deepl_code' => 'DA'],
        'de' => ['name' => 'German',     'native' => 'Deutsch',    'flag' => 'de', 'deepl_code' => 'DE'],
        'el' => ['name' => 'Greek',      'native' => 'Ελληνικά',   'flag' => 'gr', 'deepl_code' => 'EL'],
        'es' => ['name' => 'Spanish',    'native' => 'Español',    'flag' => 'es', 'deepl_code' => 'ES'],
        'et' => ['name' => 'Estonian',   'native' => 'Eesti',      'flag' => 'ee', 'deepl_code' => 'ET'],
        'fi' => ['name' => 'Finnish',    'native' => 'Suomi',      'flag' => 'fi', 'deepl_code' => 'FI'],
        'fr' => ['name' => 'French',     'native' => 'Français',   'flag' => 'fr', 'deepl_code' => 'FR'],
        'ga' => ['name' => 'Irish',      'native' => 'Gaeilge',    'flag' => 'ie', 'deepl_code' => null],
        'hr' => ['name' => 'Croatian',   'native' => 'Hrvatski',   'flag' => 'hr', 'deepl_code' => null],
        'hu' => ['name' => 'Hungarian',  'native' => 'Magyar',     'flag' => 'hu', 'deepl_code' => 'HU'],
        'it' => ['name' => 'Italian',    'native' => 'Italiano',   'flag' => 'it', 'deepl_code' => 'IT'],
        'lt' => ['name' => 'Lithuanian', 'native' => 'Lietuvių',   'flag' => 'lt', 'deepl_code' => 'LT'],
        'lv' => ['name' => 'Latvian',    'native' => 'Latviešu',   'flag' => 'lv', 'deepl_code' => 'LV'],
        'mt' => ['name' => 'Maltese',    'native' => 'Malti',      'flag' => 'mt', 'deepl_code' => null],
        'nl' => ['name' => 'Dutch',      'native' => 'Nederlands', 'flag' => 'nl', 'deepl_code' => 'NL'],
        'pl' => ['name' => 'Polish',     'native' => 'Polski',     'flag' => 'pl', 'deepl_code' => 'PL'],
        'pt' => ['name' => 'Portuguese', 'native' => 'Português',  'flag' => 'pt', 'deepl_code' => 'PT-PT'],
        'ro' => ['name' => 'Romanian',   'native' => 'Română',     'flag' => 'ro', 'deepl_code' => 'RO'],
        'sk' => ['name' => 'Slovak',     'native' => 'Slovenčina', 'flag' => 'sk', 'deepl_code' => 'SK'],
        'sl' => ['name' => 'Slovenian',  'native' => 'Slovenščina','flag' => 'si', 'deepl_code' => 'SL'],
        'sv' => ['name' => 'Swedish',    'native' => 'Svenska',    'flag' => 'se', 'deepl_code' => 'SV'],
    ],

    'default_language' => 'en',

    'fallback_language' => 'en',

    // Auto-translate when missing translations
    'auto_translate' => env('AUTO_TRANSLATE', true),

    // Store translations in database
    'use_database' => env('TRANSLATIONS_USE_DB', true),
];
