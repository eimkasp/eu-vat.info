# Architecture Overview

This document provides a high-level overview of the EU VAT Info application's architecture.

## Core Technologies

- **Backend:** Laravel (PHP Framework)
- **Frontend:** Livewire (Full-stack framework for Laravel), Blade (Templating Engine), Tailwind CSS (Utility-first CSS framework), Alpine.js (Minimal JavaScript framework)
- **Database:** MySQL

## Application Structure

The application follows a standard Laravel structure with some key directories:

- `app/`: Contains the core application code.
  - `Http/Controllers/`: Handles HTTP requests (though most logic is in Livewire components).
  - `Livewire/`: Contains all Livewire components, which handle most of the application's interactive logic and state management.
  - `Models/`: Defines the Eloquent models (`Country`, `CountryAnalytic`).
  - `Providers/`: Service providers for bootstrapping application services.
  - `Services/`: Contains business logic services like `CountryAnalyticsService`.
  - `Traits/`: Reusable code snippets used across different classes.
  - `View/Components/`: Contains Blade view components.
- `config/`: Application configuration files.
- `database/`: Database migrations, factories, and seeders.
- `public/`: Publicly accessible assets (CSS, JS, images).
- `resources/`: Frontend assets (CSS, JS) and Blade views.
  - `views/`: Contains Blade templates, including layouts and Livewire component views.
- `routes/`: Defines application routes (`web.php`, `api.php`).
- `tests/`: Contains application tests (Unit, Feature).
- `docs/`: Contains this documentation.

## Key Architectural Concepts

- **Livewire Components:** The application heavily relies on Livewire for building dynamic interfaces. Most pages and interactive elements are implemented as Livewire components, reducing the need for extensive custom JavaScript. State management, user interactions, and backend communication are primarily handled within these components.
- **Eloquent Models:** Data persistence is managed through Laravel's Eloquent ORM. The `Country` model stores VAT rate information, while `CountryAnalytic` tracks user interactions.
- **Service Layer:** Business logic, like tracking analytics, is encapsulated in services (`CountryAnalyticsService`) to keep components focused on presentation logic.
- **Traits:** Reusable functionalities, such as view tracking (`TracksCountryViews`) and analytics relationships (`HasAnalytics`), are implemented as traits for easy inclusion in relevant classes.
- **Caching:** Country data is cached (`Cache::remember`) to improve performance.
- **Routing:** Routes defined in `routes/web.php` map URLs to Livewire components or controllers.

## Data Flow Example (VAT Calculator)

1.  User navigates to `/vat-calculator/{slug}`.
2.  The route maps to the `VatCalculator` Livewire component.
3.  The `mount()` method fetches the `Country` data based on the slug and initializes component properties (amount, rates, etc.).
4.  The component renders the `livewire.vat-calculator.blade.php` view.
5.  User interacts with the form (changes amount, selects rate, chooses include/exclude VAT).
6.  Livewire handles these interactions, updating component properties via AJAX requests.
7.  Updated properties trigger the `calculateVat()` method.
8.  The method performs the calculation and updates the `total` and `vat_amount` properties.
9.  Livewire re-renders the relevant parts of the Blade view with the updated data.
10. If the user saves the search, the `saveSearch()` method is called, storing data in the session and tracking the event via `CountryAnalyticsService`.

## Further Reading

- [Database Schema](./database-schema.md)
- [Analytics System](./analytics-system.md)
- [Livewire Components](../components/livewire/)
