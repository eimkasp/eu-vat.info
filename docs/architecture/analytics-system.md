# Analytics System

The EU VAT Info application includes a system for tracking user interactions and page views related to countries. This helps understand application usage and popular content.

## Core Components

- **`CountryAnalytic` Model:** ([../models/country-analytics.md](./../models/country-analytics.md)) Stores individual tracking events. Each record links to a `Country` and contains details about the interaction.
- **`CountryAnalyticsService`:** ([../services/country-analytics-service.md](./../services/country-analytics-service.md)) A dedicated service responsible for creating `CountryAnalytic` records. It handles fetching user location data based on IP address and populating the analytics record.
- **`TracksCountryViews` Trait:** ([../traits/tracks-country-views.md](./../traits/tracks-country-views.md)) A helper trait used in Livewire components (`VatCalculator`, `CountryPage`) to easily trigger view tracking via the `CountryAnalyticsService`.
- **`HasAnalytics` Trait:** ([../traits/has-analytics.md](./../traits/has-analytics.md)) Added to the `Country` model to define the `hasMany` relationship with `CountryAnalytic` and provide helper methods like `getViewsCount()`.

## Tracking Process

1.  **Trigger:** An action occurs that needs tracking (e.g., a Livewire component mounts, a calculator interaction happens, a search is saved).
2.  **Trait Method Call:** The component calls the `trackCountryView()` method provided by the `TracksCountryViews` trait, passing the relevant `Country` object, the type of event (e.g., 'view', 'calculator', 'saved'), and optional metadata.
3.  **Service Invocation:** The `trackCountryView()` method resolves the `CountryAnalyticsService` from the service container and calls its `trackView()` method.
4.  **Data Collection:** The `CountryAnalyticsService` gathers information:
    - User's IP address (`$request->ip()`)
    - User agent string (`$request->userAgent()`)
    - Referrer URL (`$request->header('referer')`)
    - Geolocation data (country, city) using the `stevebauman/location` package based on the IP address.
    - Metadata passed from the trigger point (e.g., calculator amount, rate used).
5.  **Record Creation:** The service creates a new `CountryAnalytic` record in the database, populating it with the collected data and the provided `type` and `country_id`.

## Tracked Event Types

- **`view`:** General page view for a country (e.g., visiting `/country/{slug}`).
- **`calculator-view`:** Specific view of the VAT calculator page for a country (`/vat-calculator/{slug}`).
- **`calculator`:** An interaction with the VAT calculator (likely triggered on calculation, though the current implementation might track on mount/update - needs verification). Metadata includes `amount` and `rate_used`.
- **`saved`:** When a user saves their calculator search configuration. Metadata includes `amount`, `rate_used`, `result`, and `vat_included`.

## Data Stored

For each tracked event, the following information is stored in the `country_analytics` table:

- Associated Country ID
- Event Type
- User IP Address
- User Agent
- Referrer
- Location (Country, City)
- Specific metadata (Amount, Rate Used for calculator events)
- Timestamp

## Potential Uses

- Identifying popular countries and features.
- Understanding user demographics (based on location).
- Analyzing usage patterns of the VAT calculator.
- Generating reports on application activity (e.g., using Filament admin panel widgets like `LatestAnalytics`).

## Further Reading

- [Database Schema](./database-schema.md)
- [`CountryAnalytic` Model](../models/country-analytics.md)
- [`CountryAnalyticsService`](../services/country-analytics-service.md)
- [`TracksCountryViews` Trait](../traits/tracks-country-views.md)
- [`HasAnalytics` Trait](../traits/has-analytics.md)
