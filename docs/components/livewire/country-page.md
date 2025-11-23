# CountryPage Livewire Component

**Namespace:** `App\Livewire`

This component is responsible for displaying the detailed information page for a specific country.

*(Note: There is also an `App\Livewire\Country` component which appears identical. This documentation assumes `CountryPage` is the one used by the `country.show` route).*

## Associated View

- `resources/views/livewire/country.blade.php` (Based on the `render` method)

## Associated Route

- `GET /country/{slug}` (Route name: `country.show`)
- `GET /country/{slug}/history` (Route name: `country.vat.history`) - *Likely handled within this component or its view.*
- `GET /country/{slug}/vat-guide` (Route name: `country.vat.guide`) - *Likely handled within this component or its view.*

## Traits

- **`TracksCountryViews`:** ([../../traits/tracks-country-views.md](../../traits/tracks-country-views.md)) Used to track the 'country-view' event when the page is loaded.

## Properties

- **`$country`:** The `Country` model instance corresponding to the slug in the URL.

## Methods

- **`mount($slug)`:** Initializes the component.
    - Fetches the `Country` model from the database using the provided `$slug`. It uses `firstOrFail()` to automatically throw a 404 error if the country is not found.
    - Calls `trackCountryView()` from the `TracksCountryViews` trait to record a 'country-view' analytic event for this country.
- **`render()`:** Returns the associated Blade view (`livewire.country.blade.php`).

## Key Functionality

- Fetches and displays detailed information for a specific country based on the URL slug.
- Tracks page views for the specific country being displayed.
- Likely renders different sections (details, history, guide) based on the specific route accessed, possibly controlled within the Blade view.

## View Interaction (Assumed)

The `livewire.country.blade.php` view receives the `$country` object and uses its properties (`name`, `standard_rate`, `reduced_rate`, `content`, `description`, etc.) to display the country's VAT information. It might include:

- Country name and flag.
- Tables or lists of VAT rates.
- The detailed content stored in the `content` field.
- Potentially other related components like a mini-calculator or links to related countries.
- Logic to display different content based on the specific route (`/history`, `/vat-guide`).

## Further Reading

- [`Country` Model](../../models/country.md)
- [`TracksCountryViews` Trait](../../traits/tracks-country-views.md)
- [Analytics System](../../architecture/analytics-system.md)
