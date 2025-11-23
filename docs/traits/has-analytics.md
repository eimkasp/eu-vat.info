# HasAnalytics Trait

**Namespace:** `App\Traits`

This trait is designed to be used with models that have associated analytics data stored in the `country_analytics` table (primarily the `Country` model in this application). It provides the relationship definition and helper methods for accessing analytics counts.

## Dependencies

- `App\Models\CountryAnalytic`: The model representing the analytics records.
- `Illuminate\Database\Eloquent\Relations\HasMany`: Eloquent relationship type.

## Methods

- **`analytics(): HasMany`**
    - **Purpose:** Defines the one-to-many relationship between the model using this trait (e.g., `Country`) and the `CountryAnalytic` model.
    - **Returns:** An Eloquent `HasMany` relationship instance.
    - **Logic:** `return $this->hasMany(CountryAnalytic::class);`

- **`getViewsCount(): int`**
    - **Purpose:** Calculates the total number of 'view' type analytics events associated with this model instance.
    - **Returns:** An integer representing the count of 'view' events.
    - **Logic:** Accesses the `analytics` relationship and filters by `type = 'view'`, then counts the results. `return $this->analytics()->where('type', 'view')->count();`

- **`getCalculatorUsageCount(): int`**
    - **Purpose:** Calculates the total number of 'calculator' type analytics events associated with this model instance.
    - **Returns:** An integer representing the count of 'calculator' events.
    - **Logic:** Accesses the `analytics` relationship and filters by `type = 'calculator'`, then counts the results. `return $this->analytics()->where('type', 'calculator')->count();`

## Usage

This trait is added to the `Country` model to easily access its related analytics data.

```php
use App\Traits\HasAnalytics;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasAnalytics;

    // ... other model code ...
}

// Example of accessing the methods:
$country = Country::find(1);

// Get all analytics records for the country
$allAnalytics = $country->analytics;

// Get the count of page views
$viewCount = $country->getViewsCount();

// Get the count of calculator interactions
$calculatorCount = $country->getCalculatorUsageCount();
```

## Key Functionality

- Establishes the Eloquent relationship between a model and its analytics records.
- Provides convenient helper methods to quickly retrieve counts for specific types of analytics events ('view', 'calculator').
- Promotes code reuse by encapsulating the relationship and common counting logic.

## Further Reading

- [`Country` Model](../../models/country.md)
- [`CountryAnalytic` Model](../../models/country-analytics.md)
- [Analytics System](../../architecture/analytics-system.md)
- [Eloquent Relationships (Laravel Docs)](https://laravel.com/docs/eloquent-relationships#one-to-many)
