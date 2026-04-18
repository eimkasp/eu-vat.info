# VIES VAT Number Validation Skill

Validate EU VAT numbers in real-time via the official VIES (VAT Information Exchange System) database, served through eu-vat.info with multi-layer caching.

## What You Can Do

- Validate any EU VAT number against the official EU VIES database
- Retrieve the registered company name and address for valid numbers
- Batch-validate up to 10 VAT numbers in a single request
- Check validity for all 27 EU member states (note: Greece uses country code `EL`)

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

### MCP Tool: `validate_vat_number`

**Input:**
| Parameter      | Type   | Required | Description |
|----------------|--------|----------|-------------|
| `country_code` | string | yes      | Two-letter ISO country code. Greece uses `"EL"`, not `"GR"`. |
| `vat_number`   | string | yes      | VAT number **without** the country prefix (e.g. `"123456789"` for `DE123456789`) |

```json
{
  "jsonrpc": "2.0",
  "id": 1,
  "method": "tools/call",
  "params": {
    "name": "validate_vat_number",
    "arguments": {
      "country_code": "DE",
      "vat_number": "123456789"
    }
  }
}
```

**Response (valid):**
```json
{
  "valid": true,
  "country_code": "DE",
  "vat_number": "123456789",
  "company_name": "Example GmbH",
  "company_address": "Musterstraße 1, 10115 Berlin"
}
```

**Response (invalid):**
```json
{
  "valid": false,
  "country_code": "DE",
  "vat_number": "000000000",
  "company_name": null,
  "company_address": null
}
```

## REST API

### Single Validation

```
POST https://eu-vat.info/api/vat/validation/validate
Content-Type: application/json

{
  "country_code": "DE",
  "vat_number": "123456789"
}
```

### Batch Validation (up to 10)

```
POST https://eu-vat.info/api/vat/validation/batch
Content-Type: application/json

{
  "numbers": [
    { "country_code": "DE", "vat_number": "123456789" },
    { "country_code": "LT", "vat_number": "100001919314" }
  ]
}
```

### Health Check

```
GET https://eu-vat.info/api/vat/validation/health
```

## Country Code Reference

| Country | Code | Country | Code |
|---------|------|---------|------|
| Austria | AT | Latvia | LV |
| Belgium | BE | Lithuania | LT |
| Bulgaria | BG | Luxembourg | LU |
| Croatia | HR | Malta | MT |
| Cyprus | CY | Netherlands | NL |
| Czech Republic | CZ | Poland | PL |
| Denmark | DK | Portugal | PT |
| Estonia | EE | Romania | RO |
| Finland | FI | Slovakia | SK |
| France | FR | Slovenia | SI |
| Germany | DE | Spain | ES |
| **Greece** | **EL** | Sweden | SE |
| Hungary | HU | | |
| Ireland | IE | | |
| Italy | IT | | |

> **Note:** Greece uses `EL` (not `GR`) per the VIES standard.

## Caching Behaviour

Results are cached via a multi-layer strategy (Redis → Database → VIES API) to reduce load on the EU VIES service. Cache TTL is typically 1 hour for valid numbers and shorter for invalid ones.

## Human-Readable Reference

- Interactive validator: `https://eu-vat.info/country/{slug}` (Validator tab)
- MCP server guide: `https://eu-vat.info/mcp-server`
