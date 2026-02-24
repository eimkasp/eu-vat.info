<?php

use Illuminate\Support\Facades\App;

if (!function_exists('locale_url')) {
    /**
     * Generate a locale-aware URL for a named route.
     * English (default) gets no prefix; other locales get /{locale}/...
     */
    function locale_url(string $name, array $parameters = [], bool $absolute = true): string
    {
        $locale = App::getLocale();
        $default = config('translation.default_language', 'en');

        if ($locale !== $default) {
            $parameters['locale'] = $locale;
        }

        return route($name, $parameters, $absolute);
    }
}

if (!function_exists('locale_path')) {
    /**
     * Prefix a raw path with the current locale if not default.
     */
    function locale_path(string $path = '/'): string
    {
        $locale = App::getLocale();
        $default = config('translation.default_language', 'en');

        if ($locale !== $default) {
            return '/' . $locale . ($path === '/' ? '' : $path);
        }

        return $path;
    }
}

if (!function_exists('supported_locales')) {
    /**
     * Get all supported locale configs.
     */
    function supported_locales(): array
    {
        return config('translation.supported_languages', []);
    }
}

if (!function_exists('current_locale_config')) {
    /**
     * Get the config for the current locale.
     */
    function current_locale_config(): array
    {
        $locale = App::getLocale();
        return config("translation.supported_languages.{$locale}", []);
    }
}
