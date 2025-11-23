# Home Livewire Component

**Namespace:** `App\Livewire`

This component represents the main home page of the application. It displays a list of EU countries, potentially allows searching/filtering, and might interact with other components like the `EuropeMap`.

## Associated View

- `resources/views/livewire/home.blade.php`

## Associated Route

- `GET /` (Route name: `home`)

## Properties

- **`$euCountries`:** A collection of `Country` models, filtered by the `$search` term and ordered by standard rate.
- **`$search`:** A string property bound to a search input field, used to filter the list of countries. Default: `''`.
- **`$selectedCountryIso`:** Stores the ISO code of a country selected, possibly via interaction with the `EuropeMap` component. Default: `null`.

## Methods

- **`mount()`:** Initializes the component. Calls `listenForCountrySelection()`.
- **`listenForCountrySelection()`:** Currently empty, but likely intended to listen for events dispatched from other components (e.g., `EuropeMap`) indicating a country selection.
- **`countrySelected($isoCode)`:** A public method that can be called (potentially via Livewire events) to update the `$selectedCountryIso` property.
- **`render()`:** Fetches the `$euCountries` collection based on the current `$search` term and returns the associated Blade view (`livewire.home.blade.php`).

## Key Functionality

- Displays the main landing page.
- Fetches and lists EU countries, ordered by standard VAT rate.
- Allows users to filter the country list via a search input (`$search`).
- Potentially interacts with other components (like `EuropeMap`) to reflect country selections (`$selectedCountryIso`).

## View Interaction (Assumed)

The `livewire.home.blade.php` view likely:

- Includes an input field bound to the `$search` property (`wire:model="search"`).
- Iterates over the `$euCountries` collection to display a list or table of countries with their VAT rates.
- Includes the `EuropeMap` component (`<livewire:europe-map />`), possibly passing `$selectedCountryIso` or listening for events.
- May include other introductory content or links.

## Further Reading

- [`Country` Model](../../models/country.md)
- [`EuropeMap`](./europe-map.md)
