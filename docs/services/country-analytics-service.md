# CountryAnalyticsService

**Namespace:** `App\Services`

This service encapsulates the logic for tracking user interactions related to countries and storing them as `CountryAnalytic` records.

## Dependencies

- `App\Models\Country`: The country model being tracked.
- `Illuminate\Http\Request`: Used to access request details like IP address, user agent, and referrer.
- `Stevebauman\Location\Facades\Location`: Facade for the `stevebauman/location` package, used to derive geolocation data from the IP address.

## Methods

- **`trackView(Country $country, Request $request, string $type = 'view', array $metadata = []): void`**
    - **Purpose:** Creates a new `CountryAnalytic` record.
    - **Parameters:**
        - `$country`: The `Country` instance the event relates to.
        - `$request`: The current HTTP request instance.
        - `$type`: A string indicating the type of event (e.g., 'view', 'calculator', 'saved'). Default is 'view'.
        - `$metadata`: An optional array containing additional data specific to the event type (e.g., `amount`, `rate_used` for calculator events).
    - **Logic:**
        1. Uses `Location::get($request->ip())` to attempt to retrieve geolocation data based on the user's IP address.
        2. Creates a new `CountryAnalytic` record associated with the provided `$country`.
        3. Populates the record with:
            - `type`
            - `ip_address`
            - `user_agent`
            - `referer`
            - `location_country` (from Location lookup, or null)
            - `location_city` (from Location lookup, or null)
            - `amount` (from `$metadata`, or null)
            - `rate_used` (from `$metadata`, or null)
            - `meta_data` (the full `$metadata` array, or null if empty)

## Usage

This service is typically injected or resolved from the container where tracking is needed. The `TracksCountryViews` trait provides a convenient way to access this service's functionality within Livewire components.

```php
// Example usage (simplified, often done via the trait)
use App\Services\CountryAnalyticsService;
use App\Models\Country;
use Illuminate\Http\Request;

// ...

$analyticsService = app(CountryAnalyticsService::class);
$country = Country::find(1);
$request = request(); // Get current request

$analyticsService->trackView(
    $country,
    $request,
    'calculator',
    ['amount' => 100, 'rate_used' => 21]
);
```

## Key Functionality

- Centralizes the logic for creating analytics records.
- Integrates with the `stevebauman/location` package for geolocation.
- Handles the extraction of relevant data from the request and metadata.
- Persists tracking information to the `country_analytics` table.

## Further Reading

- [Analytics System](../../architecture/analytics-system.md)
- [`CountryAnalytic` Model](../../models/country-analytics.md)
- [`TracksCountryViews` Trait](../../traits/tracks-country-views.md)
- [`stevebauman/location` package documentation](https://github.com/stevebauman/location)
