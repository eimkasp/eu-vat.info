# TracksCountryViews Trait

**Namespace:** `App\Traits`

This trait provides a convenient method for Livewire components or other classes to track view events or interactions related to a specific `Country`.

## Dependencies

- `App\Services\CountryAnalyticsService`: The service used to perform the actual tracking.
- `App\Models\Country`: The model representing the country being tracked.

## Methods

- **`trackCountryView($country, $type = 'view', $metadata = [])` (protected)**
    - **Purpose:** A helper method to easily trigger the `CountryAnalyticsService`.
    - **Parameters:**
        - `$country`: The `Country` instance to track the event for. Can be null, in which case the method returns early.
        - `$type`: A string indicating the type of event (e.g., 'view', 'calculator', 'saved'). Default is 'view'.
        - `$metadata`: An optional array containing additional data specific to the event type.
    - **Logic:**
        1. Checks if `$country` is null. If so, it returns immediately.
        2. Resolves an instance of `CountryAnalyticsService` from the Laravel service container using `app()`.
        3. Calls the `trackView()` method on the resolved service instance, passing along all the parameters.

## Usage

This trait is intended to be used within classes (primarily Livewire components in this application) that need to track events associated with a country.

```php
use App\Traits\TracksCountryViews;
use App\Models\Country;
use Livewire\Component;

class MyComponent extends Component
{
    use TracksCountryViews;

    public Country $country;

    public function mount($slug)
    {
        $this->country = Country::where('slug', $slug)->firstOrFail();

        // Track the initial view
        $this->trackCountryView($this->country, 'view');
    }

    public function performAction()
    {
        // ... perform some action ...

        // Track a specific interaction
        $this->trackCountryView($this->country, 'custom-action', ['details' => 'some data']);
    }

    // ...
}
```

## Key Functionality

- Simplifies the process of tracking country-related events.
- Decouples the calling class from the specific implementation details of the `CountryAnalyticsService`.
- Provides a consistent way to trigger tracking across different components.
- Includes a null check for the `$country` object for safety.

## Further Reading

- [`CountryAnalyticsService`](../services/country-analytics-service.md)
- [Analytics System](../../architecture/analytics-system.md)
