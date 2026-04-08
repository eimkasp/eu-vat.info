[![Laravel Forge Site Deployment Status](https://img.shields.io/endpoint?url=https%3A%2F%2Fforge.laravel.com%2Fsite-badges%2F516661be-8281-4b22-b780-b3a98db5eb8c%3Fdate%3D1%26commit%3D1&style=flat)](https://forge.laravel.com/servers/773218/sites/2296001)

# EU VAT Info

The most comprehensive, daily-updated source for VAT rates, calculators, validators, and historical data for all 27 EU member states. Built with Laravel 11, Livewire 3, and Tailwind CSS.

**Live site:** [eu-vat.info](https://vat.businesspress.io)

## Features

- **VAT Calculator** — Add or remove VAT for any EU country with real-time rates. Shareable calculation URLs.
- **VAT Number Validator** — Verify EU VAT numbers against the official VIES system with multi-layer caching (Redis → Database → VIES API).
- **Interactive VAT Map** — SVG heatmap of Europe showing standard VAT rates at a glance.
- **VAT Rate History** — Timeline of all VAT rate changes across EU member states with direction indicators.
- **Country Pages** — Dedicated pages for each of the 27 EU countries with rates, calculator, validator, and compliance guides.
- **Embeddable Widget** — Drop-in VAT calculator widget for third-party websites.
- **24 EU Languages** — Full i18n support with automated DeepL translations.
- **REST API** — JSON endpoints for countries, VAT rates, and VAT number validation.
- **AI/LLM Integration** — `llms.txt`, MCP server endpoint, and LLM-optimized JSON for AI agent consumption.
- **SEO Optimized** — Structured data (JSON-LD), multi-language XML sitemaps with hreflang, Open Graph tags.

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP 8.2+, Laravel 11 |
| Frontend | Livewire 3, Volt, Blade, Tailwind CSS 3, DaisyUI 4, MaryUI |
| Admin | Filament 3 |
| Testing | Pest 2 / PHPUnit 10 |
| Database | MySQL (production), SQLite (testing) |
| API | Laravel Sanctum, REST JSON |
| i18n | 24 EU languages, DeepL API |
| SEO | Spatie Sitemap, hreflang, `llms.txt`, JSON-LD |
| Deploy | Laravel Forge, Vite 5 |
| Monitoring | Laravel Pulse |

## Supported Languages

All 24 official EU languages are supported. Translations are automated via DeepL where available.

| Code | Language | Code | Language | Code | Language |
|---|---|---|---|---|---|
| `en` | English | `fr` | French | `pl` | Polish |
| `bg` | Bulgarian | `ga` | Irish | `pt` | Portuguese |
| `cs` | Czech | `hr` | Croatian | `ro` | Romanian |
| `da` | Danish | `hu` | Hungarian | `sk` | Slovak |
| `de` | German | `it` | Italian | `sl` | Slovenian |
| `el` | Greek | `lt` | Lithuanian | `sv` | Swedish |
| `es` | Spanish | `lv` | Latvian | | |
| `et` | Estonian | `mt` | Maltese | | |
| `fi` | Finnish | `nl` | Dutch | | |

English is the default language and uses unprefixed URLs (`/vat-calculator/france`). All other languages use a locale prefix (`/de/vat-calculator/france`).

> **Note:** Irish (`ga`), Croatian (`hr`), and Maltese (`mt`) do not have DeepL support and use manual translations.

## Getting Started

### Requirements

- PHP 8.2+
- Composer 2
- Node.js 18+ & npm
- MySQL 8+ (or SQLite for local development)

### Installation

```bash
# Clone the repository
git clone https://github.com/eimkasp/eu-vat.info.git
cd eu-vat.info

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Run database migrations and seed data
php artisan migrate
php artisan db:seed

# Build frontend assets
npm run build

# Start the development server
php artisan serve
```

### Development

```bash
# Start Vite dev server with HMR
npm run dev

# Run tests
php artisan test

# Code style (Laravel Pint)
./vendor/bin/pint

# Process queue jobs
php artisan queue:work

# Generate XML sitemap
php artisan sitemap:generate

# Clear caches
php artisan cache:clear && php artisan config:clear && php artisan view:clear
```

## Architecture

### Directory Overview

```
app/
├── Console/Commands/        # Artisan commands
├── Filament/                # Admin panel (Filament 3)
├── Http/
│   ├── Controllers/         # Web + API controllers
│   ├── Middleware/           # SetLocale middleware
│   └── Resources/           # API resources
├── Jobs/                    # Queue jobs (VAT sync, translations, integrity checks)
├── Livewire/                # 24 reactive components (core UI)
├── Models/                  # 10 Eloquent models
├── Services/                # Business logic (analytics, VIES, translations, sitemap)
├── Traits/                  # HasAnalytics, TracksCountryViews
└── helpers.php              # Global helpers (locale_path, etc.)
resources/views/
├── livewire/                # Livewire Blade templates
├── components/              # Reusable Blade components
└── layouts/                 # App layout
lang/                        # 24 language directories
routes/
├── web.php                  # Localised routes
├── api.php                  # REST API endpoints
└── console.php              # Scheduled commands
```

### Key Models

| Model | Purpose |
|---|---|
| `Country` | EU country with VAT rates, currency, flags, ISO codes |
| `VatRate` | Historical rates by type (standard, reduced, super-reduced, parking) |
| `VatRateChange` | Tracks old→new rate changes with direction |
| `CountryAnalytic` | User interaction tracking (views, calculations) |
| `Translation` | Database-backed i18n strings |
| `VatValidationCache` | Cached VIES validation results |
| `VatValidationLog` | VIES API request audit log |
| `Banner` | Promotional banners with scheduling |
| `DataSource` | External data source metadata |

### Services

| Service | Purpose |
|---|---|
| `ViesValidationService` | Multi-layer VAT number validation: Redis → DB → VIES API, with fuzzy matching and confidence scoring |
| `TranslationService` | Translation chain: Cache → Database → DeepL API → English fallback |
| `CountryAnalyticsService` | IP geolocation and user interaction tracking |
| `SitemapGenerator` | Multi-language XML sitemap with hreflang alternates for all 24 locales |

### Background Jobs

| Job | Purpose |
|---|---|
| `UpdateVatRates` | Sync VAT rates from external data sources |
| `GenerateVatRateChanges` | Detect and record rate changes with old→new comparison |
| `TranslateText` | Async DeepL translation for missing language keys |
| `VerifyVatRatesIntegrity` | Data consistency and validation checks |

## API

All API responses use JSON. No authentication required for read endpoints.

### Endpoints

| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/api/countries` | All countries with VAT rates (cached) |
| `GET` | `/api/countries/{slug}` | Single country details |
| `POST` | `/api/vat/validation/validate` | Validate a VAT number via VIES |
| `POST` | `/api/vat/validation/batch` | Batch validate up to 10 VAT numbers |
| `GET` | `/api/vat/validation/health` | VIES service health check |
| `GET` | `/api/llm/vat-rates` | LLM-optimized JSON with all rates |
| `POST` | `/api/mcp` | Model Context Protocol server (read-only) |

### Example

```bash
# Get all EU countries with VAT rates
curl https://vat.businesspress.io/api/countries

# Get VAT details for Germany
curl https://vat.businesspress.io/api/countries/germany

# Validate a VAT number
curl -X POST https://vat.businesspress.io/api/vat/validation/validate \
  -H "Content-Type: application/json" \
  -d '{"vat_number": "DE123456789"}'
```

## AI & LLM Integration

The site is optimized for AI agent discovery and consumption:

- **`/llms.txt`** — Structured summary following the [llms.txt standard](https://llmstxt.org) for AI discoverability
- **`/llms-full.txt`** — Complete VAT rates in Markdown table format
- **`/api/llm/vat-rates`** — Machine-readable JSON with all countries, rates, ISO codes, and timestamps
- **`/api/mcp`** — [Model Context Protocol](https://modelcontextprotocol.io) endpoint for AI tool integration

## Embeddable Widget

Add a VAT calculator to any website:

```
https://vat.businesspress.io/embed/{country?}
```

Preview and get embed code at `/embed/preview/{country}`.

## Data Sources

VAT rate data is sourced from the [European Commission](https://ec.europa.eu/taxation_customs/taxation/vat/how-vat-works/vat-rates_en) and the [kdeldycke/vat-rates](https://github.com/kdeldycke/vat-rates) dataset. Rates are synced automatically via background jobs.

## Admin Panel

The Filament 3 admin panel at `/admin` provides:

- Country and VAT rate management
- Analytics dashboard with usage statistics
- Banner management with scheduling
- Audit trail for all country data changes

## Security

If you discover a security vulnerability, please create an issue on [GitHub](https://github.com/eimkasp/eu-vat.info/issues).

## Mobile App

A native iOS and Android mobile app is available in the [`eu-vat-mobile/`](eu-vat-mobile/) directory, built with [NativePHP](https://nativephp.com) for Mobile.

| Feature | Description |
|---|---|
| VAT Rates | Browse all 27 EU countries with current rates |
| VAT Calculator | Add/remove VAT with country and rate type selection |
| VAT Validator | Verify VAT numbers against VIES |
| Platforms | iOS (Xcode 16+) and Android (Android Studio 2024.2.1+) |
| Stack | Laravel 13, Livewire 4, Tailwind CSS, NativePHP Mobile 3.2 |

The mobile app is a separate Laravel project that connects to the web app's REST API (`/api/countries`, `/api/vat/validation/validate`).

```bash
cd eu-vat-mobile
composer install && npm install
php artisan native:install
php artisan native:run
```

See [eu-vat-mobile/README.md](eu-vat-mobile/README.md) for full setup instructions.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
