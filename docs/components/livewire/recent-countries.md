# RecentCountries Livewire Component

**Namespace:** `App\Livewire`

This component displays a list of countries that the user has recently viewed.

## Associated View

- `resources/views/livewire/recent-countries.blade.php`

## Properties

- **`$recentCountries`:** A collection of `Country` models representing the recently viewed countries.

## Methods

- **`mount()`:** Initializes the component.
    - Retrieves an array of country IDs from the session key `'recent_countries'`.
    - If the array is empty, it initializes `$recentCountries` as an empty collection.
    - If IDs exist, it fetches the corresponding `Country` models from the database using `whereIn`.
    - It uses `orderByRaw('FIELD(id, ...)')` to maintain the order of countries as stored in the session (most recent first, assuming IDs are pushed onto the end).
    - Limits the results to a maximum of 6 countries.
- **`render()`:** Returns the associated Blade view (`livewire.recent-countries.blade.php`).

## Key Functionality

- Retrieves a list of recently viewed country IDs from the user's session.
- Fetches the corresponding `Country` models from the database.
- Displays these recently viewed countries, likely as links or small cards.
- Maintains the order of recency.

## Session Interaction

- **Relies on:** Another part of the application (likely the `TracksCountryViews` trait or `CountryAnalyticsService`, although not explicitly shown in the provided code) to store the viewed country IDs in the `session()->get('recent_countries', [])` array. The `TracksCountryViews` trait seems the most likely place where `session()->push('recent_countries', $country->id)` would occur after tracking a view.
- **Retrieves:** Reads the `recent_countries` array from the session during the `mount` method.

## View Interaction (Assumed)

The `livewire.recent-countries.blade.php` view iterates over the `$recentCountries` collection and displays each country, potentially showing its flag and name, and linking to the country's detail page (`country.show`).

## Further Reading

- [`Country` Model](../../models/country.md)
- [`TracksCountryViews` Trait](../../traits/tracks-country-views.md) (Likely responsible for populating the session data)
