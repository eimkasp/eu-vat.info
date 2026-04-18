# EU VAT Rates Skill

Query live EU VAT rates for all 27 EU member states via the eu-vat.info API or MCP server.

## What You Can Do

- Get current VAT rates (standard, reduced, super-reduced, parking) for any EU country
- Calculate VAT amounts (add VAT to net price, or extract VAT from gross price)
- Compare VAT rates across multiple EU countries
- Look up a country by name, ISO code (e.g. `DE`), or slug (e.g. `germany`)

## Authentication

No authentication required. All endpoints are publicly accessible.

## MCP Server (Recommended for AI Agents)

Connect via the Model Context Protocol for structured tool access:

```json
{
  "mcpServers": {
    "eu-vat-info": {
      "type": "http",
      "url": "https://eu-vat.info/api/mcp"
    }
  }
}
```

### Available MCP Tools

#### `get_all_vat_rates`
Returns standard, reduced, super-reduced, and parking rates for all 27 EU member states.

```json
{ "jsonrpc": "2.0", "id": 1, "method": "tools/call", "params": { "name": "get_all_vat_rates", "arguments": {} } }
```

#### `get_country_vat_rate`
Get VAT rates for a specific country.

**Input:**
| Parameter | Type   | Required | Description |
|-----------|--------|----------|-------------|
| `country` | string | yes      | Country name (`"Germany"`), ISO code (`"DE"`), or slug (`"germany"`) |

```json
{ "jsonrpc": "2.0", "id": 1, "method": "tools/call", "params": { "name": "get_country_vat_rate", "arguments": { "country": "DE" } } }
```

#### `calculate_vat`
Calculate VAT for a given amount and country.

**Input:**
| Parameter   | Type   | Required | Description |
|-------------|--------|----------|-------------|
| `amount`    | number | yes      | Monetary amount |
| `country`   | string | yes      | Country name, ISO code, or slug |
| `mode`      | string | no       | `"add"` (net → gross) or `"remove"` (gross → net). Default: `"add"` |
| `rate_type` | string | no       | `"standard"`, `"reduced"`, `"super_reduced"`, `"parking"`. Default: `"standard"` |

```json
{ "jsonrpc": "2.0", "id": 1, "method": "tools/call", "params": { "name": "calculate_vat", "arguments": { "amount": 100, "country": "DE", "mode": "add", "rate_type": "standard" } } }
```

#### `compare_vat_rates`
Compare standard and reduced rates across multiple EU countries.

**Input:**
| Parameter   | Type  | Required | Description |
|-------------|-------|----------|-------------|
| `countries` | array | yes      | Array of country names, ISO codes, or slugs |

```json
{ "jsonrpc": "2.0", "id": 1, "method": "tools/call", "params": { "name": "compare_vat_rates", "arguments": { "countries": ["DE", "FR", "LT"] } } }
```

## REST API

### Get All Countries

```
GET https://eu-vat.info/api/countries
```

### Get a Single Country

```
GET https://eu-vat.info/api/countries/{slug}
```

Example: `GET https://eu-vat.info/api/countries/germany`

### LLM-Optimised Rates List

```
GET https://eu-vat.info/api/llm/vat-rates
```

Returns a compact JSON array of all countries with their rates — ideal for context injection.

## Response Format

```json
{
  "country": "Germany",
  "iso_code": "DE",
  "slug": "germany",
  "rates": {
    "standard": 19,
    "reduced": 7,
    "super_reduced": null,
    "parking": null
  },
  "last_updated": "2025-01-01T00:00:00Z"
}
```

## Human-Readable Reference

- Country pages: `https://eu-vat.info/country/{slug}`
- VAT calculator: `https://eu-vat.info/vat-calculator`
- Full rates table: `https://eu-vat.info/llms-full.txt`
- MCP server guide: `https://eu-vat.info/mcp-server`
