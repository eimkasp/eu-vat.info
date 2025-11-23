# VatCalculator Livewire Component

**Namespace:** `App\Livewire`

This is the core component responsible for the VAT calculation functionality. It allows users to input an amount, select a country and VAT rate, choose whether VAT is included or excluded, and see the calculated results.

## Associated View

- `resources/views/livewire/vat-calculator.blade.php`

## Traits

- **`Toast`:** (from `mary-ui/mary`) Used for displaying toast notifications (e.g., when saving a search).
- **`TracksCountryViews`:** ([../../traits/tracks-country-views.md](../../traits/tracks-country-views.md)) Used to track views and interactions related to the calculator for a specific country.

## Properties

- **`$amount` (`#[Url]`):** The input amount for calculation (persisted in URL). Default: `100`.
- **`$country`:** The currently selected `Country` model instance.
- **`$slug`:** The slug of the currently selected country. Default: `'lithuania-lt'`.
- **`$vat`:** The VAT rate percentage (seems less used now, `$selectedRate` is primary).
- **`$vat_amount`:** The calculated VAT amount.
- **`$total`:** The calculated total amount (either including or excluding VAT based on `$vat_included`).
- **`$result`:** Seems redundant, potentially intended to hold `$total`.
- **`$selectedRate` (`#[Url]`):** The currently selected VAT rate value (persisted in URL).
- **`$vat_included` (`#[Url]`):** Determines calculation mode ('include' or 'exclude') (persisted in URL). Default: `'include'`.
- **`$rates`:** An array of available VAT rates for the selected country.
- **`$vat_options`:** Static array defining the 'Include VAT' / 'Exclude VAT' options.
- **`$selectedCountry1` (`#[Url]`):** The slug of the selected country (bound to the country dropdown, persisted in URL).
- **`$selectedCountryObject`:** The `Country` model instance corresponding to `$selectedCountry1`.
- **`$saved_searches`:** An array of recently saved search configurations loaded from the session.
- **`$countries`:** A collection of all `Country` models, used to populate the country dropdown (cached).
- **`$analyticsService`:** Injected instance of `CountryAnalyticsService`.
- **`$error_message`:** Stores error messages related to calculation (e.g., invalid input).

## Methods

- **`boot(CountryAnalyticsService $analyticsService)`:** Injects the analytics service.
- **`mount($country = null, $slug = null)`:** Initializes the component state. Fetches the country based on the slug, loads all countries for the dropdown, sets the initial selected country and rate, performs the initial calculation, loads saved searches, and tracks the initial 'calculator-view'.
- **`saveSearch()`:** Saves the current calculator parameters (`amount`, `selectedCountry1`, `selectedRate`, `vat_included`) to the session, tracks the 'saved' event via analytics, shows a success toast, and refreshes the `$saved_searches` property.
- **`clearSearch()`:** Clears saved searches from the session, shows a success toast, and resets the `$saved_searches` property.
- **`updated($property)`:** Lifecycle hook. If `$selectedCountry1` changes, it updates the `$slug`, fetches the new `$selectedCountryObject`, updates the available `$rates`, resets `$selectedRate` to the standard rate, and recalculates.
- **`calculate()`:** Explicit method to trigger calculation (potentially redundant as `calculateVat` is called on updates). Fetches country, gets rates, sets `$vat` (legacy?), calls `calculateVat`, and calls `trackVisit`.
- **`render()`:** Returns the associated Blade view.
- **`calculateVat()` (private):** The core calculation logic. Normalizes the input amount, validates it, calculates `$total` and `$vat_amount` based on `$vat_included` and `$selectedRate`, and handles potential errors.
- **`normalizeNumber($input)` (private):** Cleans the input amount string, handling European formats (comma as decimal separator) and removing non-numeric characters.
- **`isValidAmount($amount)` (private):** Checks if the amount is numeric and non-negative.
- **`calculateTotals($amount, $rate)` (private):** Performs the actual VAT calculation based on whether VAT is included or excluded.
- **`resetCalculation()` (private):** Resets calculation results (`$total`, `$vat_amount`) to 0.
- **`handleCalculationError($message)` (private):** Sets the `$error_message`, resets calculation results, and sets `$amount` to 0.
- **`getRates()` (private):** Populates the `$rates` array based on the available rates (`standard_rate`, `reduced_rate`, etc.) of the `$selectedCountryObject`.
- **`trackVisit()` (protected):** Tracks a 'calculator' event using `CountryAnalyticsService`, including metadata like `amount`, `rate_used`, and `result` (should be `total`).

## Key Functionality

- Fetches country data and VAT rates.
- Provides dropdowns for selecting country and rate.
- Allows input of a numeric amount.
- Handles both "VAT included" and "VAT excluded" calculation modes.
- Performs VAT calculations based on user input.
- Displays calculated VAT amount and total.
- Handles input validation and error display.
- Allows saving and clearing search configurations using session storage.
- Tracks component views and calculation events.
- Persists key parameters (`amount`, `selectedRate`, `vat_included`, `selectedCountry1`) in the URL query string.

## Further Reading

- [`VatCalculatorForm`](./vat-calculator-form.md) (Extends this component)
- [`Country` Model](../../models/country.md)
- [`CountryAnalyticsService`](../../services/country-analytics-service.md)
- [`TracksCountryViews` Trait](../../traits/tracks-country-views.md)
