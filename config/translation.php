<?php

return [
    'api_key' => env('DEEPL_API_KEY'),

    'supported_languages' => [
        'en' => ['name' => 'English', 'flag' => 'gb', 'deepl_code' => 'EN'],
        'de' => ['name' => 'Deutsch', 'flag' => 'de', 'deepl_code' => 'DE'],
        'fr' => ['name' => 'Français', 'flag' => 'fr', 'deepl_code' => 'FR'],
        'es' => ['name' => 'Español', 'flag' => 'es', 'deepl_code' => 'ES'],
        'it' => ['name' => 'Italiano', 'flag' => 'it', 'deepl_code' => 'IT'],
        'pl' => ['name' => 'Polski', 'flag' => 'pl', 'deepl_code' => 'PL'],
    ],

    'default_language' => 'en',

    'fallback_language' => 'en',

    // Auto-translate when missing translations
    'auto_translate' => env('AUTO_TRANSLATE', true),

    // Store translations in database
    'use_database' => env('TRANSLATIONS_USE_DB', true),
];
