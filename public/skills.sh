#!/bin/sh
# EU VAT Info — Agent Skills Discovery
# Machine-readable skill listing for AI agents
# https://vat.businesspress.io

cat <<'EOF'
{
  "name": "EU VAT Info",
  "url": "https://vat.businesspress.io",
  "description": "Free, daily-updated EU VAT rates, calculators, VIES validation, and MCP server for all 27 EU member states.",
  "auth": "none",
  "mcp_server": "https://vat.businesspress.io/api/mcp",
  "discovery": {
    "agent_skills": "https://vat.businesspress.io/.well-known/agent-skills",
    "agents_md": "https://vat.businesspress.io/agents.md",
    "llms_txt": "https://vat.businesspress.io/llms.txt",
    "api_catalog": "https://vat.businesspress.io/.well-known/api-catalog",
    "mcp_server_card": "https://vat.businesspress.io/.well-known/mcp/server-card.json"
  },
  "skills": [
    {
      "id": "vat-rates",
      "name": "EU VAT Rates",
      "description": "Query live VAT rates, calculate VAT, compare rates across EU countries.",
      "skill_url": "https://vat.businesspress.io/.well-known/agent-skills/vat-rates/SKILL.md",
      "endpoints": ["GET /api/countries", "GET /api/countries/{slug}", "GET /api/llm/vat-rates"]
    },
    {
      "id": "vies-validation",
      "name": "VIES VAT Number Validation",
      "description": "Validate EU VAT numbers against the official VIES database with company lookup.",
      "skill_url": "https://vat.businesspress.io/.well-known/agent-skills/vies-validation/SKILL.md",
      "endpoints": ["POST /api/vat/validation/validate", "POST /api/vat/validation/batch"]
    }
  ]
}
EOF
