# VatCalculatorForm Livewire Component

**Namespace:** `App\Livewire`

This component extends the main `VatCalculator` component. Its primary purpose seems to be providing a different view or context for the VAT calculator functionality, likely for embedding or specific form use cases.

## Associated View

- `resources/views/livewire/vat-calculator-form.blade.php`

## Extends

- `App\Livewire\VatCalculator` ([./vat-calculator.md](./vat-calculator.md))

## Properties

Inherits all public and protected properties from `VatCalculator`.

## Methods

- **`mount($country = null, $slug = null)`:** Overrides the parent `mount` method but simply calls `parent::mount($country, $slug)`. This ensures the same initialization logic as `VatCalculator` is executed.
- **`render()`:** Returns the specific Blade view associated with this component (`livewire.vat-calculator-form.blade.php`).

## Key Functionality

- Inherits all the VAT calculation logic, state management, and event tracking from the `VatCalculator` component.
- Provides an alternative presentation layer through its dedicated Blade view (`vat-calculator-form.blade.php`). This view might be styled differently or include/exclude certain elements compared to the main `vat-calculator.blade.php` view.

## Usage

This component is likely used in scenarios where the VAT calculator needs to be displayed as a distinct form, potentially embedded within other pages or used in contexts requiring a slightly different UI than the main calculator page.

## Further Reading

- [`VatCalculator`](./vat-calculator.md) (Parent Component)
