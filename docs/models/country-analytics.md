# CountryAnalytic Model

**Namespace:** `App\Models`

The `CountryAnalytic` model is responsible for storing records of user interactions and views related to specific countries.

## Schema

See [Database Schema](../architecture/database-schema.md#country_analytics) for detailed column information.

Key fields include:

- `country_id`: Foreign key linking to the `countries` table.
- `type`: The type of event being tracked (e.g., 'view', 'calculator', 'saved').
- `ip_address`, `user_agent`, `referer`: User request details.
- `location_country`, `location_city`: Geolocation data derived from the IP address.
- `amount`, `rate_used`: Specific data related to calculator interactions.
- `meta_data`: A JSON field for storing any additional relevant information about the event.

## Traits

- **`HasFactory`:** Enables the use of model factories for testing and seeding.

## Relationships

- **`country()`:** Defines an inverse one-to-many (belongs to) relationship with the `Country` model. This allows accessing the country associated with an analytics record.
  ```php
  public function country(): BelongsTo
  {
      return $this->belongsTo(Country::class);
  }
  ```

## Casts

- **`meta_data`:** Cast to `array` for easy handling of the JSON data.
- **`amount`**, **`rate_used`:** Cast to `decimal` with 2 decimal places for accurate storage of numeric values related to the calculator.

## Usage

- Records are created primarily by the `CountryAnalyticsService`.
- Data from this model can be used for:
  - Displaying view counts or usage statistics.
  - Generating reports on application activity.
  - Powering admin panel widgets (e.g., `LatestAnalytics` in Filament).

## Further Reading

- [`Country` Model](./country.md)
- [`CountryAnalyticsService`](../services/country-analytics-service.md)
- [Analytics System](../architecture/analytics-system.md)
- [Database Schema](../architecture/database-schema.md)
