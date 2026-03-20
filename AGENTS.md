# EU VAT Info — Agent Instructions

## Project Overview

EU VAT Info (`eu-vat.info`) is a Laravel 11 web application providing comprehensive EU VAT rate information, calculators, validators, and country-specific guides. It serves developers, businesses, and tax professionals with real-time data sourced from the European Commission.

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | PHP 8.2+, Laravel 11 |
| Frontend | Livewire 3, Volt, Blade, Tailwind CSS 3, DaisyUI 4, MaryUI |
| Admin | Filament 3 |
| Testing | Pest 2 / PHPUnit 10 |
| Database | MySQL (production), SQLite (testing) |
| API | Laravel Sanctum, REST JSON endpoints |
| i18n | 24 EU languages, DeepL API integration |
| SEO | Spatie Sitemap, hreflang, `llms.txt`, structured data |
| Deploy | Laravel Forge, Vite 5 |
| Monitoring | Laravel Pulse |

## Architecture

### Directory Structure

```
app/
├── Console/Commands/          # Artisan commands
├── Filament/                  # Admin panel (Filament 3)
│   ├── Pages/                 # Dashboard
│   ├── Resources/             # Country, Analytics, Banner resources
│   └── Widgets/               # Admin dashboard widgets
├── Http/
│   ├── Controllers/           # 3 web + 2 API controllers
│   ├── Middleware/             # SetLocale middleware
│   └── Resources/             # API resources
├── Jobs/                      # 4 async queue jobs
├── Livewire/                  # 18 reactive components (core UI)
├── Models/                    # 10 Eloquent models
├── Providers/                 # Service providers
├── Services/                  # 4 business logic services
├── Traits/                    # HasAnalytics, TracksCountryViews
├── View/                      # View composers
└── helpers.php                # 4 global helper functions
resources/
├── views/
│   ├── livewire/              # 18 Livewire Blade templates
│   ├── components/            # 18 reusable Blade components
│   ├── layouts/               # App layout
│   └── widget/                # Embed widget views
├── css/                       # Tailwind source
└── js/                        # Alpine.js / app scripts
lang/                          # 24 language directories (bg, cs, da, de, el, en, es, et, fi, fr, ga, hr, hu, it, lt, lv, mt, nl, pl, pt, ro, sk, sl, sv)
routes/
├── web.php                    # Localised routes (/{locale}/path)
├── api.php                    # REST API endpoints
└── console.php                # Scheduled commands
```

### Models

| Model | Purpose | Key Relations |
|-------|---------|---------------|
| `Country` | EU country with VAT rates, currency, flags | hasMany VatRate, CountryAnalytic, VatRateChange |
| `VatRate` | Historical rates by type (standard/reduced/super/parking) | belongsTo Country |
| `VatRateChange` | Tracks old→new rate changes with direction | belongsTo Country |
| `CountryAnalytic` | User interaction tracking (views, calculations) | belongsTo Country |
| `Translation` | DB-backed i18n strings | — |
| `Banner` | Promotional content with scheduling | — |
| `VatValidationCache` | Cached VIES validation results | — |
| `VatValidationLog` | VIES API request logs | — |
| `DataSource` | External data source metadata | — |
| `User` | Admin users for Filament | — |

### Livewire Components (Core UI)

| Component | Route | Purpose |
|-----------|-------|---------|
| `Home` | `/` | Landing page with country grid |
| `CountryPage` | `/country/{slug}/{tab?}` | Country detail with tabs (overview, calculator, validator, history, guide) |
| `VatCalculator` | `/vat-calculator/{slug?}` | Full VAT calculator with URL params |
| `VatValidator` | — | VIES VAT number validation |
| `VatMap` | `/vat-map` | Interactive Europe map |
| `VatChangesHistory` | `/vat-changes` | Timeline of VAT rate changes |
| `HtmlSitemap` | `/sitemap` | HTML sitemap for SEO |
| `EuropeMap` | embedded | SVG interactive map component |
| `VatRateHistoryChart` | embedded | Chart.js rate history |
| `VatCalculatorSimple` | embedded | Simplified calculator widget |

### Services

| Service | Purpose |
|---------|---------|
| `CountryAnalyticsService` | IP geolocation + interaction tracking |
| `ViesValidationService` | Multi-layer cache: Redis → DB → VIES API, fuzzy matching, confidence scoring |
| `SitemapGenerator` | 24-language XML sitemap with locale alternates |
| `TranslationService` | DeepL + DB + cache fallback chain |

### Jobs (Queue)

| Job | Purpose |
|-----|---------|
| `SyncVatRatesFromGithub` | Auto-sync VAT rates from kdeldycke/vat-rates |
| `DetectVatRateChanges` | Compare old/new rates and create VatRateChange records |
| `TranslateText` | DeepL async translation for missing keys |
| `VerifyDataIntegrity` | Data consistency checks |

### API Endpoints

```
GET  /api/countries              # All countries (cached 600s)
GET  /api/countries/{slug}       # Single country
POST /api/vat/validate           # Validate VAT number
POST /api/vat/validate/batch     # Batch validate (max 10)
GET  /api/health                 # Health check
```

## Key Conventions

### Routing
- Localised routes use `/{locale}/path` prefix for non-English languages
- English (default) has no prefix: `/country/germany`
- Route registration uses a `$registerRoutes` closure applied to both locale-prefixed and root groups
- Language switch: `GET /lang/{locale}`

### Translations
- 24 EU languages supported (all official EU languages)
- Default: English (`en`)
- Translation chain: Cache → Database → DeepL API → Fallback to English
- Language files in `lang/{locale}/ui.php`
- Config: `config/translation.php`
- Languages without DeepL: `ga` (Irish), `hr` (Croatian), `mt` (Maltese)

### Frontend
- All interactive UI uses **Livewire 3 components** — no SPA framework
- Styling: **Tailwind CSS 3** + **DaisyUI 4** (custom theme `mytheme`) + **MaryUI** components
- Dark mode: class-based (`darkMode: 'class'`)
- Icons: Blade Feather Icons
- Charts: Chart.js (via Livewire)

### Testing
- Framework: **Pest 2** (preferred) with PHPUnit 10 underneath
- Test location: `tests/Feature/` and `tests/Unit/`
- Run tests: `php artisan test` or `./vendor/bin/pest`
- Lint: `./vendor/bin/pint` (Laravel Pint)

### Admin Panel
- **Filament 3** at `/admin`
- Resources: Country, CountryAnalytic, Banner
- Widgets: Dashboard stats, charts
- Auditing: `owen-it/laravel-auditing` on Country model

## Development Workflow

### Common Commands

```bash
# Development
php artisan serve                    # Start dev server
npm run dev                          # Vite HMR
npm run build                        # Production build

# Testing
php artisan test                     # Run all tests
./vendor/bin/pest                    # Run Pest tests
./vendor/bin/pest --filter=ClassName # Run specific test
./vendor/bin/pint                    # Code style fix

# Database
php artisan migrate                  # Run migrations
php artisan db:seed                  # Seed data

# Sitemap
php artisan sitemap:generate         # Or visit /sitemap/generate

# Cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Queues
php artisan queue:work               # Process jobs
```

### Adding a New Feature

**New Livewire page:**
1. Create component: `php artisan make:livewire PageName`
2. Add route in `routes/web.php` inside the `$registerRoutes` closure (so it works for all locales)
3. Create Blade view in `resources/views/livewire/`
4. Add translations to all 24 `lang/{locale}/ui.php` files (or use TranslationService)

**New country tab:**
1. Add tab slug to the `where('tab', '...')` regex in `routes/web.php`
2. Add tab component/partial in the `CountryPage` Livewire component
3. Update sitemap generator to include new tab URLs

**New API endpoint:**
1. Add route to `routes/api.php`
2. Create controller in `app/Http/Controllers/Api/`
3. Create API resource in `app/Http/Resources/`

**New translation key:**
1. Add to `lang/en/ui.php`
2. Run translation job or manually add to all 24 locales
3. Use `__('ui.key_name')` in Blade templates

### Deployment
- Hosted on **Laravel Forge** (auto-deploy on push to `main`)
- Build: Vite compiles assets during deploy
- Queue worker managed by Forge/Supervisor
