<?php

namespace App\Console\Commands;

use App\Jobs\TranslateText;
use App\Models\Translation;
use Illuminate\Console\Command;

class TranslateMissing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:missing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch jobs to translate missing keys for all supported languages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sourceLocale = config('translation.fallback_language', 'en');
        $supportedLocales = array_keys(config('translation.supported_languages', []));

        // Get all source translations
        // Assuming source keys are stored with locale = $sourceLocale
        // If your system uses 'key' as the identifier and doesn't store source text separately,
        // you might need to distinct() on 'key'.

        $keys = Translation::select('key', 'group')
            ->distinct()
            ->pluck('key'); // Simplified: assuming simple keys

        // If you store the English value in the DB, you can fetch it.
        // If not, and the key IS the text, we use the key.

        $this->info('Found '.$keys->count().' unique translation keys.');

        foreach ($keys as $key) {
            foreach ($supportedLocales as $locale) {
                if ($locale === $sourceLocale) {
                    continue;
                }

                // Check if exists
                $exists = Translation::where('key', $key)
                    ->where('locale', $locale)
                    ->exists();

                if (! $exists) {
                    $this->info("Dispatching translation for [$locale]: $key");
                    TranslateText::dispatch($key, $locale, $sourceLocale);
                }
            }
        }

        $this->info('Translation jobs dispatched.');
    }
}
