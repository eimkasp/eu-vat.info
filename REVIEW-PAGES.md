# Pages to Review - November 27, 2025

Server is running on: **http://127.0.0.1:8001**

## Main Pages

### 1. Homepage
- **URL**: http://127.0.0.1:8001
- **Features**: All countries list, recent updates, search

### 2. VAT Map
- **URL**: http://127.0.0.1:8001/vat-map
- **Features**: Interactive EU map with VAT rates

### 3. VAT Calculator (Standalone)
- **URL**: http://127.0.0.1:8001/vat-calculator
- **Features**: Global VAT calculator

### 4. VAT Changes History
- **URL**: http://127.0.0.1:8001/vat-changes
- **Features**: Historical VAT rate changes

---

## Country Pages (New Tabbed Interface)

### Example Country: Germany
Base URL: http://127.0.0.1:8001/country/germany

#### Tab 1: Overview
- **URL**: http://127.0.0.1:8001/country/germany
- **Features**: 
  - VAT rate information
  - Country statistics
  - VAT guide content
  - Quick facts
  - Calculation examples
- **Check**: Meta tags, breadcrumbs, structured data

#### Tab 2: VAT Calculator ⭐ NEW
- **URL**: http://127.0.0.1:8001/country/germany/vat-calculator
- **Features**:
  - Add/Remove VAT toggle
  - Real-time calculation
  - Quick amount buttons (€100, €1000, €10000)
  - Custom VAT rate input
  - Calculation formulas
- **Check**: Calculations work, transitions smooth, URL updates

#### Tab 3: VAT Number Validator ⭐ NEW
- **URL**: http://127.0.0.1:8001/country/germany/vat-validator
- **Features**:
  - EU country dropdown (pre-selected to Germany)
  - VAT number validation
  - VIES API integration
  - Fuzzy matching with confidence scores
  - Company name and address display
  - 7-day caching
- **Check**: Validation works, confidence bars display, error handling

---

## Test These Countries

### Germany (DE)
- Overview: http://127.0.0.1:8001/country/germany
- Calculator: http://127.0.0.1:8001/country/germany/vat-calculator
- Validator: http://127.0.0.1:8001/country/germany/vat-validator

### France (FR)
- Overview: http://127.0.0.1:8001/country/france
- Calculator: http://127.0.0.1:8001/country/france/vat-calculator
- Validator: http://127.0.0.1:8001/country/france/vat-validator

### Netherlands (NL)
- Overview: http://127.0.0.1:8001/country/netherlands
- Calculator: http://127.0.0.1:8001/country/netherlands/vat-calculator
- Validator: http://127.0.0.1:8001/country/netherlands/vat-validator

### Spain (ES)
- Overview: http://127.0.0.1:8001/country/spain
- Calculator: http://127.0.0.1:8001/country/spain/vat-calculator
- Validator: http://127.0.0.1:8001/country/spain/vat-validator

### Poland (PL)
- Overview: http://127.0.0.1:8001/country/poland
- Calculator: http://127.0.0.1:8001/country/poland/vat-calculator
- Validator: http://127.0.0.1:8001/country/poland/vat-validator

---

## API Endpoints (Test with Browser/Postman)

### VAT Validation API
- **Health Check**: http://127.0.0.1:8001/api/vat/validation/health
- **Single Validation** (POST): http://127.0.0.1:8001/api/vat/validation/validate
- **Batch Validation** (POST): http://127.0.0.1:8001/api/vat/validation/batch

### Countries API
- **All Countries**: http://127.0.0.1:8001/api/vat/countries

---

## Testing Checklist

### Tab Navigation
- [ ] Clicking tabs updates URL without page reload
- [ ] Browser back/forward buttons work correctly
- [ ] Active tab is highlighted with blue border
- [ ] Tab content transitions smoothly (fade + slide up)
- [ ] Direct URL access works (e.g., bookmark calculator tab)

### VAT Calculator Tab
- [ ] Add VAT mode calculates correctly
- [ ] Remove VAT mode calculates correctly
- [ ] Quick amount buttons work (€100, €1000, €10000)
- [ ] Custom VAT rate input works
- [ ] Results display in colored box
- [ ] Net, VAT, and Gross amounts all correct
- [ ] Decimal precision (2 places)

### VAT Validator Tab
- [ ] Country dropdown pre-selected correctly
- [ ] VAT number input accepts text
- [ ] Validation button disabled when empty
- [ ] Loading spinner appears during validation
- [ ] Success/error messages display correctly
- [ ] Company details show when available
- [ ] Confidence score bars display (green/yellow/red)
- [ ] Clear button resets form
- [ ] Error handling works gracefully

### SEO Elements
- [ ] Each tab has unique `<title>` tag
- [ ] Meta descriptions are unique per tab
- [ ] Canonical URLs are correct
- [ ] Breadcrumbs display correctly
- [ ] Open Graph tags present
- [ ] JSON-LD structured data valid

### Responsive Design
- [ ] Tabs scroll horizontally on mobile
- [ ] Calculator layout adapts to mobile
- [ ] Validator works on small screens
- [ ] Sidebar collapses properly
- [ ] All buttons are touch-friendly

### Dark Mode
- [ ] Tab navigation readable in dark mode
- [ ] Calculator form inputs visible
- [ ] Result boxes have good contrast
- [ ] Validator widget looks good
- [ ] All text is readable

### Sidebar Links
- [ ] "VAT Calculator" link points to tab URL
- [ ] "VAT Number Validator" has "New" badge
- [ ] "Embed VAT Widget" link works
- [ ] All links have hover effects
- [ ] Icons display correctly

---

## Sitemap
- **URL**: http://127.0.0.1:8001/sitemap.xml
- **Check**: All country tab URLs are included

---

## Known Issues to Watch For

1. **Livewire Component Loading**: VatCalculatorSimple and VatValidationWidget should load instantly
2. **Alpine.js Transitions**: Should be smooth, not jumpy
3. **VIES API**: May timeout or be unavailable (check error handling)
4. **Cache**: First validation may be slow, second should be instant
5. **Mobile Tabs**: May need horizontal scroll on small screens

---

## Test Scenarios

### Scenario 1: New User Flow
1. Visit homepage
2. Click on Germany
3. Should see Overview tab by default
4. Click "VAT Calculator" tab
5. Enter €1000, see calculation
6. Click "VAT Number Validator" tab
7. Enter DE123456789
8. See validation result

### Scenario 2: Direct URL Access
1. Visit http://127.0.0.1:8001/country/france/vat-calculator directly
2. Should land on calculator tab
3. Calculator should be pre-loaded with France's rate (20%)
4. Check URL and meta tags

### Scenario 3: SEO Crawling Simulation
1. Visit each tab URL directly
2. View page source (Cmd+U / Ctrl+U)
3. Verify:
   - `<title>` is unique
   - `<meta name="description">` is unique
   - `<link rel="canonical">` is correct
   - JSON-LD structured data is present

---

## Quick Test with curl

```bash
# Test API health
curl http://127.0.0.1:8001/api/vat/validation/health

# Test VAT validation
curl -X POST http://127.0.0.1:8001/api/vat/validation/validate \
  -H "Content-Type: application/json" \
  -d '{"country_code":"DE","vat_number":"123456789"}'
```

---

## Notes for Review

- **New Features**: Tab system with SEO-friendly URLs
- **Components**: VatCalculatorSimple (new), VatValidationWidget (new)
- **SEO**: Unique meta tags, structured data, sitemap integration
- **UX**: Smooth transitions, browser history support, loading states
- **API**: VIES validation with fuzzy matching and caching

**Last Updated**: November 27, 2025
