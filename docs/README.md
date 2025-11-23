# EU VAT Info Documentation

This documentation provides a comprehensive overview of the EU VAT Info application, its architecture, components, and functionality.

## Overview

EU VAT Info is a web application that provides information about Value Added Tax (VAT) rates across European Union countries. The application allows users to:

- View VAT rates for all EU countries
- Calculate VAT for specific amounts
- Explore country-specific VAT information
- Save and track calculator configurations
- View recently visited countries
- Visualize VAT rates on an interactive map of Europe

## Documentation Structure

- [Architecture](./architecture/overview.md) - High-level system architecture and design
  - [Database Schema](./architecture/database-schema.md) - Database structure and relationships
  - [Analytics System](./architecture/analytics-system.md) - User interaction tracking system

- [Models](./models/) - Data models and their relationships
  - [Country](./models/country.md) - Country model with VAT rate information
  - [CountryAnalytic](./models/country-analytics.md) - Analytics tracking model

- [Livewire Components](./components/livewire/) - Interactive UI components
  - [VatCalculator](./components/livewire/vat-calculator.md) - VAT calculation component
  - [EuropeMap](./components/livewire/europe-map.md) - Interactive map component
  - [CountryPage](./components/livewire/country-page.md) - Country details page
  - [Home](./components/livewire/home.md) - Home page component
  - [RecentCountries](./components/livewire/recent-countries.md) - Recently viewed countries component

- [Blade Components](./components/blade/) - UI components
  - [Country Rates](./components/blade/country-rates.md) - Country VAT rates display
  - [Saved Searches](./components/blade/saved-searches.md) - Saved calculator configurations

- [Services](./services/) - Business logic services
  - [CountryAnalyticsService](./services/country-analytics-service.md) - Analytics tracking service

- [Traits](./traits/) - Reusable trait functionality
  - [TracksCountryViews](./traits/tracks-country-views.md) - Country view tracking functionality
  - [HasAnalytics](./traits/has-analytics.md) - Analytics relationship functionality

## Key Features

1. **VAT Calculator** - Calculate VAT for different EU countries with various rates
2. **Europe Map** - Interactive map showing VAT rates across Europe
3. **Country Pages** - Detailed information about VAT in specific countries
4. **Analytics System** - Tracks user interactions and country views
5. **Recent Countries** - Shows recently viewed countries
6. **Saved Searches** - Allows users to save calculator configurations

## Technology Stack

- Laravel - PHP framework
- Livewire - Interactive components
- Tailwind CSS - Styling
- Alpine.js - JavaScript functionality
- MySQL - Database

## Getting Started

For development setup and contribution guidelines, please refer to the main [README.md](../README.md) file in the project root.
