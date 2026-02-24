<?php

namespace App\Console\Commands;

use App\Services\SitemapGenerator;
use Illuminate\Console\Command;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate {--url= : Override APP_URL (e.g. https://vat.businesspress.io)}';
    protected $description = 'Generate the public/sitemap.xml file with all pages and hreflang alternates';

    public function handle(SitemapGenerator $generator): int
    {
        if ($url = $this->option('url')) {
            $generator->setBaseUrl($url);
        }

        $path = $generator->writeToFile();
        $count = substr_count(file_get_contents($path), '<url>');

        $this->info("Sitemap written to {$path} ({$count} URLs, base: {$generator->getBaseUrl()})");

        return self::SUCCESS;
    }
}
