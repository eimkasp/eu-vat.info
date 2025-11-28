# Country Page Tab System

## Overview
The country pages now use a tabbed interface with SEO-friendly URLs for different features. Each tab has its own unique URL, meta tags, and structured data for optimal search engine visibility.

## Tab URLs
- **Overview**: `/country/{slug}` - Main country information and VAT rates
- **VAT Calculator**: `/country/{slug}/vat-calculator` - Calculate VAT for the country
- **VAT Validator**: `/country/{slug}/vat-validator` - Validate VAT numbers using VIES

## Adding New Tabs

### 1. Update Route Constraint
Edit `routes/web.php` and add the new tab to the route constraint:

```php
Route::get('/country/{slug}/{tab}', CountryPage::class)->name('country.tab')
    ->where('tab', 'vat-calculator|vat-validator|history|vat-guide|your-new-tab');
```

### 2. Add Tab Configuration
Edit `app/Livewire/CountryPage.php` and add to the `getTabs()` method:

```php
'your-new-tab' => [
    'name' => 'Your Tab Name',
    'icon' => 'M... (SVG path data)',
    'url' => route('country.tab', ['slug' => $this->country->slug, 'tab' => 'your-new-tab']),
    'title' => "SEO Title for {$this->country->name}",
    'description' => "SEO description for the tab",
],
```

### 3. Add Tab Content
Edit `resources/views/livewire/country.blade.php` and add a new tab content section:

```blade
<!-- Your New Tab -->
<div x-show="activeTab === 'your-new-tab'" 
     x-transition:enter="transition ease-out duration-200" 
     x-transition:enter-start="opacity-0 transform translate-y-4" 
     x-transition:enter-end="opacity-100 transform translate-y-0">
    @if($activeTab === 'your-new-tab')
        <!-- Tab content here -->
    @endif
</div>
```

### 4. Update Sitemap (Optional)
If the tab should appear in the sitemap, edit `app/Http/Controllers/SitemapController.php`:

```php
$sitemap .= '<url>';
$sitemap .= '<loc>' . route('country.tab', ['slug' => $country->slug, 'tab' => 'your-new-tab']) . '</loc>';
$sitemap .= '<lastmod>' . $country->updated_at->toAtomString() . '</lastmod>';
$sitemap .= '<changefreq>monthly</changefreq>';
$sitemap .= '<priority>0.8</priority>';
$sitemap .= '</url>';
```

## SEO Features

### Meta Tags
Each tab has unique:
- `<title>` tag
- Meta description
- Canonical URL
- Open Graph tags (Facebook/LinkedIn)
- Twitter Card tags

### Structured Data
The page includes JSON-LD structured data:
- **WebPage** schema with breadcrumb navigation
- **GovernmentService** schema for VAT information
- **SoftwareApplication** schema for the calculator tab

### URL Structure
- Clean, readable URLs: `/country/germany/vat-calculator`
- Proper route constraints prevent invalid tab names
- Livewire handles client-side navigation with `wire:navigate`
- Alpine.js updates browser history without page reloads

## Components

### VatCalculatorSimple
Location: `app/Livewire/VatCalculatorSimple.php`

Simplified VAT calculator for embedding in tabs:
- Add/Remove VAT modes
- Real-time calculation
- Quick amount buttons (€100, €1,000, €10,000)
- Supports custom VAT rates

### VatValidationWidget
Location: `app/Livewire/VatValidationWidget.php`

VAT number validator using VIES:
- EU country selection
- Real-time validation
- Fuzzy matching for company names/addresses
- Confidence scores
- 7-day caching

## Technical Details

### State Management
- `activeTab` property synced with Livewire
- Alpine.js handles tab visibility transitions
- Browser history updated via `history.pushState()`

### Performance
- Conditional rendering: only active tab content is rendered server-side
- Alpine transitions for smooth UX
- Livewire wire:navigate for instant client-side navigation

### Accessibility
- Semantic HTML structure
- Proper ARIA labels on tab navigation
- Keyboard navigation support via standard `<a>` tags

## Testing Checklist

When adding a new tab:
- [ ] Route is accessible: `/country/germany/{tab}`
- [ ] Tab appears in navigation
- [ ] Clicking tab updates URL
- [ ] Back/forward browser buttons work
- [ ] Meta tags are unique per tab
- [ ] Mobile responsive
- [ ] Dark mode support
- [ ] Added to sitemap (if needed)
- [ ] Structured data is valid (test with Google Rich Results)

## Example Implementation

See the VAT Calculator tab for a complete example:
- Route: `country.tab` with parameter `vat-calculator`
- Component: `VatCalculatorSimple.php`
- View: `resources/views/livewire/vat-calculator-simple.blade.php`
- SEO: Unique title, description, and SoftwareApplication schema
