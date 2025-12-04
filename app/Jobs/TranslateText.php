<?php

namespace App\Jobs;

use App\Models\Translation;
use DeepL\Translator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TranslateText implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $key;

    public $targetLocale;

    public $sourceLocale;

    public $group;

    /**
     * Create a new job instance.
     */
    public function __construct(string $key, string $targetLocale, string $sourceLocale = 'en', ?string $group = null)
    {
        $this->key = $key;
        $this->targetLocale = $targetLocale;
        $this->sourceLocale = $sourceLocale;
        $this->group = $group;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $apiKey = config('translation.api_key');

        if (! $apiKey) {
            Log::warning('DeepL API key not configured for translation job.');

            return;
        }

        try {
            // Check if translation already exists to avoid duplicate work
            $exists = Translation::where('key', $this->key)
                ->where('locale', $this->targetLocale)
                ->where('group', $this->group)
                ->exists();

            if ($exists) {
                return;
            }

            $translator = new Translator($apiKey);

            $deeplCode = config("translation.supported_languages.{$this->targetLocale}.deepl_code");

            if (! $deeplCode) {
                Log::warning("Unsupported language for DeepL: {$this->targetLocale}");

                return;
            }

            // Map 'en' to 'EN-GB' or 'EN-US' if needed, or let DeepL handle 'EN' (deprecated) or specific
            // config("translation.supported_languages.en.deepl_code") usually returns 'EN-GB' or similar

            $result = $translator->translateText(
                $this->key,
                null, // Source language auto-detect or specify if needed.
                // Ideally we pass source lang, but 'en' might need mapping.
                // If source is 'en', let's try to leave it null for auto-detect or pass explicitly if mapped.
                $deeplCode
            );

            if ($result) {
                Translation::create([
                    'key' => $this->key,
                    'locale' => $this->targetLocale,
                    'value' => $result->text,
                    'group' => $this->group,
                ]);
            }

        } catch (\Exception $e) {
            Log::error("Translation job failed for key '{$this->key}': ".$e->getMessage());
        }
    }
}
