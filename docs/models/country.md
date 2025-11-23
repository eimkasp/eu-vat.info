# Country Model

**Namespace:** `App\Models`

The `Country` model represents a European Union country and stores its relevant VAT information.

## Schema

See [Database Schema](../architecture/database-schema.md#countries) for detailed column information.

Key fields include:

- `name`: Country name
- `slug`: URL slug
- `iso_code`: Two-letter ISO code
- `standard_rate`, `reduced_rate`, `super_reduced_rate`, `zero_rate`, `parking_rate`: Various VAT rates
- `currency`, `currency_code`, `currency_symbol`: Currency details
- `flag`: Flag identifier
- `content`, `description`: Additional textual content

## Traits

- **`HasFactory`:** Enables the use of model factories for testing and seeding.
- **`HasSlug`:** (from `spatie/laravel-sluggable`) Automatically generates the `slug` from the `name` field upon saving.
- **`HasAnalytics`:** ([../traits/has-analytics.md](./../traits/has-analytics.md)) Provides the `analytics()` relationship and helper methods for accessing analytics data.
- **`Auditable`:** (from `owen-it/laravel-auditing`) Tracks changes made to the model instances.

## Relationships

- **`analytics()`:** Defines a one-to-many relationship with the `CountryAnalytic` model.
  ```php
  public function analytics(): HasMany
  {
      return $this->hasMany(CountryAnalytic::class);
  }
  ```

## Methods

- **`getSlugOptions()`:** Configures the `spatie/laravel-sluggable` package to generate slugs from the `name` field and save them to the `slug` column.
- **`countryRank()`:** Calculates the rank of the country based on its standard VAT rate compared to other countries.
  ```php
  public function countryRank()
  {
      return Country::where('standard_rate', '<', $this->standard_rate)->count() + 1;
  }
  ```
- **`toSitemapTag()`:** (from `spatie/laravel-sitemap`) Defines the URLs associated with this model that should be included in the sitemap. It returns URLs for the country detail page and the country-specific VAT calculator page.
  ```php
  public function toSitemapTag(): Url|string|array
  {
      return [route('country.show', $this->slug), route('vat-calculator.country', $this->slug)];
  }
  ```

## Usage

The `Country` model is central to the application, used in various components:

- Fetched in `VatCalculator` to get rates for calculations.
- Fetched in `EuropeMap` to display rates on the map.
- Fetched in `CountryPage` to display detailed country information.
- Fetched in `Home` to list countries.
- Used as the basis for tracking in `CountryAnalytic`.

## Further Reading

- [`CountryAnalytic` Model](./country-analytics.md)
- [`HasAnalytics` Trait](../traits/has-analytics.md)
- [Database Schema](../architecture/database-schema.md)
