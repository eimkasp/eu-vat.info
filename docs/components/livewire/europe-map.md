# EuropeMap Livewire Component

**Namespace:** `App\Livewire`

This component renders an interactive SVG map of Europe, visually representing VAT rates for different countries. It can highlight a specific country and potentially adjust its layout.

## Associated View

- `resources/views/livewire/europe-map.blade.php` (Likely contains SVG markup and logic to bind data)

## Properties

- **`$countries`:** A collection of all `Country` models, fetched from cache or database. Used to populate `$countryData`.
- **`$countryData`:** An associative array mapping uppercase ISO codes (e.g., 'DE') to country details (ISO code, name, standard rate, reduced rate, slug, active status). This is likely passed to the frontend (JavaScript/Alpine.js) to interact with the map SVG.
- **`$maxRate`:** The maximum standard VAT rate found among all countries. Used for color scaling or legends.
- **`$minRate`:** The minimum standard VAT rate found among all countries. Used for color scaling or legends.
- **`$activeCountry`:** An optional `Country` model instance representing the currently highlighted or selected country on the map.
- **`$layout`:** A string indicating the layout mode ('single' or 'split'). Default: `'single'`. This might control how the map is displayed alongside other content.

## Methods

- **`mount($activeCountry = null, $layout = 'single')`:** Initializes the component.
    - Sets the `$activeCountry` and `$layout` properties based on passed parameters.
    - Fetches all `Country` models (using caching via `Cache::remember('map_countries', 600, ...)`).
    - Calculates `$maxRate` and `$minRate` by iterating through the fetched countries.
    - Populates the `$countryData` array, mapping uppercase ISO codes to relevant country details and setting the 'active' flag based on `$activeCountry`.
- **`render()`:** Returns the associated Blade view (`livewire.europe-map.blade.php`).

## Key Functionality

- Fetches VAT data for all EU countries.
- Calculates the range (min/max) of standard VAT rates.
- Prepares data (`$countryData`) in a format suitable for frontend map interaction (likely JavaScript).
- Renders an SVG map of Europe.
- Can highlight a specific country (`$activeCountry`).
- Potentially adjusts its display based on the `$layout` property.
- Uses caching to optimize country data retrieval.

## Frontend Interaction (Assumed)

The `$countryData` property is likely passed to the Blade view and used by JavaScript (possibly Alpine.js) to:

- Color-code countries on the SVG map based on their VAT rates (using `$minRate` and `$maxRate` for scaling).
- Display tooltips or information panels when hovering over or clicking countries.
- Handle interactions like clicking a country to navigate to its detail page (using the `slug`).
- Visually highlight the `$activeCountry`.

## Further Reading

- [`Country` Model](../../models/country.md)
