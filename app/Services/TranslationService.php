<?php

namespace App\Services;

use DeepL\Translator;
use App\Models\Translation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    protected $translator;
    
    public function __construct()
    {
        $apiKey = config('translation.api_key');
        
        if ($apiKey) {
            try {
                $this->translator = new Translator($apiKey);
            } catch (\Exception $e) {
                Log::error('DeepL initialization failed: ' . $e->getMessage());
            }
        }
    }
    
    /**
     * Translate text using DeepL API
     */
    public function translate(string $text, string $targetLang, string $sourceLang = 'EN'): ?string
    {
        if (!$this->translator) {
            return null;
        }
        
        try {
            $deeplCode = config("translation.supported_languages.{$targetLang}.deepl_code");
            
            if (!$deeplCode) {
                Log::warning("Unsupported language: {$targetLang}");
                return null;
            }
            
            $result = $this->translator->translateText(
                $text,
                $sourceLang,
                $deeplCode
            );
            
            return $result->text;
        } catch (\Exception $e) {
            Log::error("Translation failed: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get translation from cache/database or translate if missing
     */
    public function get(string $key, string $locale = null, string $group = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $fallback = config('translation.fallback_language', 'en');
        
        // Return key if English (source language)
        if ($locale === $fallback) {
            return $key;
        }
        
        // Check cache first
        $cacheKey = "translation.{$locale}.{$group}.{$key}";
        
        return Cache::remember($cacheKey, 3600, function () use ($key, $locale, $group, $fallback) {
            // Check database
            $translation = Translation::get($key, $locale, $group);
            
            if ($translation) {
                return $translation;
            }
            
            // Auto-translate if enabled
            if (config('translation.auto_translate', true)) {
                $translated = $this->translate($key, $locale, $fallback);
                
                if ($translated) {
                    // Store translation
                    Translation::create([
                        'key' => $key,
                        'locale' => $locale,
                        'value' => $translated,
                        'group' => $group,
                    ]);
                    
                    return $translated;
                }
            }
            
            // Return original key as fallback
            return $key;
        });
    }
    
    /**
     * Get available languages
     */
    public function getAvailableLanguages(): array
    {
        return config('translation.supported_languages', []);
    }
    
    /**
     * Clear translation cache
     */
    public function clearCache(): void
    {
        Cache::tags(['translations'])->flush();
    }
}
