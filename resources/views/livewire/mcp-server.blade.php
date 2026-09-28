@section('seo')
    <x-seo-meta
        title="EU VAT Rates MCP Server — Connect AI Agents to Live VAT Data"
        description="Free MCP (Model Context Protocol) server for EU VAT rates. Connect VS Code Copilot, Cursor, Claude, or any AI agent to get real-time VAT rates, calculations, and country comparisons."
        type="website" />
@endsection

<div class="bg-surface" x-data="mcpPage">
    {{-- Hero --}}
    <div class="hero-canvas py-16">
        <div class="relative mx-auto w-full max-w-5xl px-4 sm:px-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="bg-white/20 backdrop-blur rounded-xl p-2.5">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m9.86-2.814a4.5 4.5 0 00-1.242-7.244l4.5-4.5a4.5 4.5 0 016.364 6.364l-1.757 1.757" />
                    </svg>
                </div>
                <span class="text-sm font-medium bg-white/20 backdrop-blur px-3 py-1 rounded-full">Model Context Protocol</span>
            </div>
            <h1 class="text-4xl sm:text-5xl font-bold mb-4">EU VAT Rates MCP Server</h1>
            <p class="text-lg text-white/85 max-w-2xl mb-8">Connect your AI assistant to real-time EU VAT data. Get rates, calculate VAT, and compare countries — directly from VS Code, Cursor, or any MCP-compatible client.</p>
            <div class="flex flex-wrap gap-3">
                <button @click="showInstall = 'vscode'" class="bg-surface text-action hover:bg-action-soft px-5 py-3 rounded-xl font-semibold flex items-center gap-2 transition-colors shadow-lg">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M23.15 2.587L18.21.21a1.494 1.494 0 0 0-1.705.29l-9.46 8.63-4.12-3.128a.999.999 0 0 0-1.276.057L.327 7.261A1 1 0 0 0 .326 8.74L3.899 12 .326 15.26a1 1 0 0 0 .001 1.479L1.65 17.94a.999.999 0 0 0 1.276.057l4.12-3.128 9.46 8.63a1.492 1.492 0 0 0 1.704.29l4.942-2.377A1.5 1.5 0 0 0 24 20.06V3.939a1.5 1.5 0 0 0-.85-1.352zm-5.146 14.861L10.826 12l7.178-5.448v10.896z" /></svg>
                    Add to VS Code
                </button>
                <button @click="showInstall = 'cursor'" class="bg-white/15 hover:bg-white/25 backdrop-blur text-white px-5 py-3 rounded-xl font-semibold flex items-center gap-2 transition-colors border border-white/20">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.562 8.248l-6.438 8.25a.75.75 0 01-1.186.038l-3.5-4a.75.75 0 111.124-.992l2.88 3.292 5.882-7.538a.75.75 0 111.238.95z" /></svg>
                    Add to Cursor
                </button>
                <button @click="showInstall = 'claude'" class="bg-white/15 hover:bg-white/25 backdrop-blur text-white px-5 py-3 rounded-xl font-semibold flex items-center gap-2 transition-colors border border-white/20">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-6h2v6zm4 0h-2v-6h2v6zm-2-8c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1z" /></svg>
                    Add to Claude Desktop
                </button>
            </div>
        </div>
    </div>

    <div class="mx-auto w-full max-w-5xl px-4 py-12 sm:px-6">
        {{-- Key Features --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-12">
            <div class="bg-surface-subtle rounded-xl p-5 border border-line">
                <div class="w-10 h-10 rounded-lg bg-success-soft text-success flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h3 class="font-semibold text-ink mb-1">Free & Open</h3>
                <p class="text-sm text-ink-muted">No API key, no account, no rate limits.</p>
            </div>
            <div class="bg-surface-subtle rounded-xl p-5 border border-line">
                <div class="w-10 h-10 rounded-lg bg-action-soft text-action flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                </div>
                <h3 class="font-semibold text-ink mb-1">Read-Only</h3>
                <p class="text-sm text-ink-muted">Safe to use — only reads data, never writes.</p>
            </div>
            <div class="bg-surface-subtle rounded-xl p-5 border border-line">
                <div class="w-10 h-10 rounded-lg bg-action-soft text-action flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                </div>
                <h3 class="font-semibold text-ink mb-1">Auto-Updated</h3>
                <p class="text-sm text-ink-muted">Rates synced daily from official EU sources.</p>
            </div>
            <div class="bg-surface-subtle rounded-xl p-5 border border-line">
                <div class="w-10 h-10 rounded-lg bg-success-soft text-success flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h3 class="font-semibold text-ink mb-1">VIES Validation</h3>
                <p class="text-sm text-ink-muted">Live EU VAT number validation via VIES.</p>
            </div>
        </div>

        {{-- Install Instructions Modal/Panel --}}
        <template x-if="showInstall">
            <div class="mb-12 bg-surface-subtle rounded-2xl border border-line overflow-hidden" x-transition>
                <div class="flex items-center justify-between bg-surface-muted px-6 py-4 border-b border-line">
                    <h2 class="text-lg font-bold text-ink flex items-center gap-2">
                        <template x-if="showInstall === 'vscode'"><span>Install in VS Code</span></template>
                        <template x-if="showInstall === 'cursor'"><span>Install in Cursor</span></template>
                        <template x-if="showInstall === 'claude'"><span>Install in Claude Desktop</span></template>
                    </h2>
                    <button @click="showInstall = null" class="text-ink-quiet hover:text-ink-muted">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <div class="p-6 space-y-5">
                    {{-- VS Code --}}
                    <div x-show="showInstall === 'vscode'">
                        <div class="space-y-4">
                            <div class="flex gap-4">
                                <div class="shrink-0 w-8 h-8 rounded-full bg-action-soft text-action font-bold flex items-center justify-center text-sm">1</div>
                                <div>
                                    <h3 class="font-semibold text-ink mb-1">Open your VS Code settings</h3>
                                    <p class="text-sm text-ink-muted">Open the Command Palette (<code class="bg-surface-muted px-1.5 py-0.5 rounded-sm text-xs font-mono">Cmd+Shift+P</code> on Mac or <code class="bg-surface-muted px-1.5 py-0.5 rounded-sm text-xs font-mono">Ctrl+Shift+P</code> on Windows) and type <strong>"MCP: Add Server"</strong>.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="shrink-0 w-8 h-8 rounded-full bg-action-soft text-action font-bold flex items-center justify-center text-sm">2</div>
                                <div class="w-full">
                                    <h3 class="font-semibold text-ink mb-1">Choose "HTTP" as the server type</h3>
                                    <p class="text-sm text-ink-muted mb-2">When prompted for the URL, enter:</p>
                                    <div class="relative">
                                        <pre class="bg-code text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">{{ $mcpUrl }}</pre>
                                        <button @click="copyToClipboard('{{ $mcpUrl }}')" class="absolute top-2 right-2 bg-code-muted hover:bg-white/15 text-white/75 p-1.5 rounded-md transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="shrink-0 w-8 h-8 rounded-full bg-action-soft text-action font-bold flex items-center justify-center text-sm">3</div>
                                <div>
                                    <h3 class="font-semibold text-ink mb-1">Name it "eu-vat-info"</h3>
                                    <p class="text-sm text-ink-muted">That's it! You can now ask Copilot about VAT rates in chat.</p>
                                </div>
                            </div>

                            <div class="mt-4 bg-action-soft border border-action/25 rounded-xl p-4">
                                <p class="text-sm text-action-deep font-medium mb-2">Or add manually to settings.json:</p>
                                <div class="relative">
                                    <pre class="bg-code text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto whitespace-pre">{
  "mcp": {
    "servers": {
      "eu-vat-info": {
        "type": "http",
        "url": "{{ $mcpUrl }}"
      }
    }
  }
}</pre>
                                    <button @click="copyToClipboard(vscodeConfig)" class="absolute top-2 right-2 bg-code-muted hover:bg-white/15 text-white/75 p-1.5 rounded-md transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Cursor --}}
                    <div x-show="showInstall === 'cursor'">
                        <div class="space-y-4">
                            <div class="flex gap-4">
                                <div class="shrink-0 w-8 h-8 rounded-full bg-action-soft text-action font-bold flex items-center justify-center text-sm">1</div>
                                <div>
                                    <h3 class="font-semibold text-ink mb-1">Open Cursor Settings</h3>
                                    <p class="text-sm text-ink-muted">Go to <strong>Cursor Settings → MCP</strong> and click <strong>"Add new MCP server"</strong>.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="shrink-0 w-8 h-8 rounded-full bg-action-soft text-action font-bold flex items-center justify-center text-sm">2</div>
                                <div class="w-full">
                                    <h3 class="font-semibold text-ink mb-1">Add the following configuration</h3>
                                    <p class="text-sm text-ink-muted mb-2">Paste this into your <code class="bg-surface-muted px-1.5 py-0.5 rounded-sm text-xs font-mono">.cursor/mcp.json</code> file:</p>
                                    <div class="relative">
                                        <pre class="bg-code text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto whitespace-pre">{
  "mcpServers": {
    "eu-vat-info": {
      "url": "{{ $mcpUrl }}"
    }
  }
}</pre>
                                        <button @click="copyToClipboard(cursorConfig)" class="absolute top-2 right-2 bg-code-muted hover:bg-white/15 text-white/75 p-1.5 rounded-md transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="shrink-0 w-8 h-8 rounded-full bg-action-soft text-action font-bold flex items-center justify-center text-sm">3</div>
                                <div>
                                    <h3 class="font-semibold text-ink mb-1">Start chatting!</h3>
                                    <p class="text-sm text-ink-muted">The EU VAT tools will now be available in Cursor's AI chat.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Claude Desktop --}}
                    <div x-show="showInstall === 'claude'">
                        <div class="space-y-4">
                            <div class="flex gap-4">
                                <div class="shrink-0 w-8 h-8 rounded-full bg-action-soft text-action font-bold flex items-center justify-center text-sm">1</div>
                                <div>
                                    <h3 class="font-semibold text-ink mb-1">Open Claude Desktop config</h3>
                                    <p class="text-sm text-ink-muted">Open <strong>Claude → Settings → Developer → Edit Config</strong>. This opens the <code class="bg-surface-muted px-1.5 py-0.5 rounded-sm text-xs font-mono">claude_desktop_config.json</code> file.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="shrink-0 w-8 h-8 rounded-full bg-action-soft text-action font-bold flex items-center justify-center text-sm">2</div>
                                <div class="w-full">
                                    <h3 class="font-semibold text-ink mb-1">Add the server config</h3>
                                    <div class="relative">
                                        <pre class="bg-code text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto whitespace-pre">{
  "mcpServers": {
    "eu-vat-info": {
      "url": "{{ $mcpUrl }}"
    }
  }
}</pre>
                                        <button @click="copyToClipboard(claudeConfig)" class="absolute top-2 right-2 bg-code-muted hover:bg-white/15 text-white/75 p-1.5 rounded-md transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="shrink-0 w-8 h-8 rounded-full bg-action-soft text-action font-bold flex items-center justify-center text-sm">3</div>
                                <div>
                                    <h3 class="font-semibold text-ink mb-1">Restart Claude Desktop</h3>
                                    <p class="text-sm text-ink-muted">Fully quit and reopen Claude Desktop to load the new MCP server.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        {{-- Available Tools --}}
        <h2 class="text-2xl font-bold text-ink mb-6">Available Tools</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-12">
            <div class="bg-surface rounded-xl border border-line p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-3 mb-3">
                    <code class="text-sm font-mono bg-action-soft text-action px-2 py-1 rounded-lg font-semibold">get_all_vat_rates</code>
                </div>
                <p class="text-sm text-ink-muted mb-3">Returns current VAT rates for all 27 EU member states including standard, reduced, super-reduced, and parking rates.</p>
                <div class="bg-surface-subtle rounded-lg p-3 border border-line">
                    <p class="text-xs text-ink-quiet mb-1.5 font-semibold uppercase tracking-wide">Example prompt</p>
                    <p class="text-sm text-ink-muted italic">"What are the current VAT rates for all EU countries?"</p>
                </div>
            </div>

            <div class="bg-surface rounded-xl border border-line p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-3 mb-3">
                    <code class="text-sm font-mono bg-action-soft text-action px-2 py-1 rounded-lg font-semibold">get_country_vat_rate</code>
                </div>
                <p class="text-sm text-ink-muted mb-3">Get detailed VAT rate info for a specific country by name, ISO code, or slug.</p>
                <div class="bg-surface-subtle rounded-lg p-3 border border-line">
                    <p class="text-xs text-ink-quiet mb-1.5 font-semibold uppercase tracking-wide">Example prompt</p>
                    <p class="text-sm text-ink-muted italic">"What's the VAT rate in Germany?"</p>
                </div>
            </div>

            <div class="bg-surface rounded-xl border border-line p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-3 mb-3">
                    <code class="text-sm font-mono bg-action-soft text-action px-2 py-1 rounded-lg font-semibold">calculate_vat</code>
                </div>
                <p class="text-sm text-ink-muted mb-3">Calculate VAT for any amount. Add VAT to a net price or extract VAT from a gross price. Supports all rate types.</p>
                <div class="bg-surface-subtle rounded-lg p-3 border border-line">
                    <p class="text-xs text-ink-quiet mb-1.5 font-semibold uppercase tracking-wide">Example prompt</p>
                    <p class="text-sm text-ink-muted italic">"Calculate VAT on €500 for France using the standard rate"</p>
                </div>
            </div>

            <div class="bg-surface rounded-xl border border-line p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-3 mb-3">
                    <code class="text-sm font-mono bg-action-soft text-action px-2 py-1 rounded-lg font-semibold">compare_vat_rates</code>
                </div>
                <p class="text-sm text-ink-muted mb-3">Compare VAT rates between two or more EU countries side-by-side.</p>
                <div class="bg-surface-subtle rounded-lg p-3 border border-line">
                    <p class="text-xs text-ink-quiet mb-1.5 font-semibold uppercase tracking-wide">Example prompt</p>
                    <p class="text-sm text-ink-muted italic">"Compare VAT rates between Germany, France, and the Netherlands"</p>
                </div>
            </div>

            <div class="bg-surface rounded-xl border border-line p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-3 mb-3">
                    <code class="text-sm font-mono bg-success-soft text-success px-2 py-1 rounded-lg font-semibold">validate_vat_number</code>
                    <span class="text-xs font-semibold bg-success-soft text-success px-2 py-0.5 rounded-full self-center">VIES</span>
                </div>
                <p class="text-sm text-ink-muted mb-3">Validate any EU VAT number against the official VIES database. Returns registration status, company name, and address for valid numbers.</p>
                <div class="bg-surface-subtle rounded-lg p-3 border border-line">
                    <p class="text-xs text-ink-quiet mb-1.5 font-semibold uppercase tracking-wide">Example prompt</p>
                    <p class="text-sm text-ink-muted italic">"Is VAT number LT100019070512 valid? Who does it belong to?"</p>
                </div>
            </div>
        </div>

        {{-- Try It / Technical Details --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <div>
                <h2 class="text-2xl font-bold text-ink mb-4">Try It Now</h2>
                <p class="text-sm text-ink-muted mb-4">Send a JSON-RPC request to the MCP endpoint to test it:</p>
                <div class="relative">
                    <pre class="bg-code text-green-400 p-5 rounded-xl text-sm font-mono overflow-x-auto whitespace-pre leading-relaxed">curl -X POST {{ $mcpUrl }} \
  -H "Content-Type: application/json" \
  -d '{
    "jsonrpc": "2.0",
    "id": 1,
    "method": "tools/call",
    "params": {
      "name": "get_country_vat_rate",
      "arguments": {
        "country": "Germany"
      }
    }
  }'</pre>
                    <button @click="copyToClipboard(curlExample)" class="absolute top-3 right-3 bg-code-muted hover:bg-white/15 text-white/75 p-1.5 rounded-md transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                    </button>
                </div>
            </div>

            <div>
                <h2 class="text-2xl font-bold text-ink mb-4">Technical Details</h2>
                <div class="bg-surface-subtle rounded-xl border border-line divide-y divide-line">
                    <div class="flex justify-between p-4">
                        <span class="text-sm text-ink-muted">Protocol</span>
                        <span class="text-sm font-medium text-ink">MCP (Model Context Protocol)</span>
                    </div>
                    <div class="flex justify-between p-4">
                        <span class="text-sm text-ink-muted">Transport</span>
                        <span class="text-sm font-medium text-ink">Streamable HTTP</span>
                    </div>
                    <div class="flex justify-between p-4">
                        <span class="text-sm text-ink-muted">Endpoint</span>
                        <code class="break-all text-sm font-mono text-ink">{{ $mcpUrl }}</code>
                    </div>
                    <div class="flex justify-between p-4">
                        <span class="text-sm text-ink-muted">Auth</span>
                        <span class="text-sm font-medium text-success">None required</span>
                    </div>
                    <div class="flex justify-between p-4">
                        <span class="text-sm text-ink-muted">Access</span>
                        <span class="text-sm font-medium text-ink">Read-only</span>
                    </div>
                    <div class="flex justify-between p-4">
                        <span class="text-sm text-ink-muted">Data freshness</span>
                        <span class="text-sm font-medium text-ink">Updated daily</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- FAQ --}}
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-ink mb-6">Frequently Asked Questions</h2>
            <div class="space-y-3" x-data="{ open: null }">
                <div class="bg-surface rounded-xl border border-line overflow-hidden">
                    <button @click="open = open === 1 ? null : 1" class="w-full flex items-center justify-between p-5 text-left">
                        <span class="font-semibold text-ink">What is MCP?</span>
                        <svg :class="open === 1 && 'rotate-180'" class="w-5 h-5 text-ink-quiet transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open === 1" x-collapse>
                        <p class="px-5 pb-5 text-sm text-ink-muted">MCP (Model Context Protocol) is an open standard that lets AI assistants like GitHub Copilot, Cursor, and Claude connect to external data sources. Think of it like a USB port for AI — it lets your AI tools plug into real-time data instead of relying on training data alone.</p>
                    </div>
                </div>
                <div class="bg-surface rounded-xl border border-line overflow-hidden">
                    <button @click="open = open === 2 ? null : 2" class="w-full flex items-center justify-between p-5 text-left">
                        <span class="font-semibold text-ink">Do I need an API key?</span>
                        <svg :class="open === 2 && 'rotate-180'" class="w-5 h-5 text-ink-quiet transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open === 2" x-collapse>
                        <p class="px-5 pb-5 text-sm text-ink-muted">No! This MCP server is completely free and requires no authentication. Just add the URL to your AI tool and start using it.</p>
                    </div>
                </div>
                <div class="bg-surface rounded-xl border border-line overflow-hidden">
                    <button @click="open = open === 3 ? null : 3" class="w-full flex items-center justify-between p-5 text-left">
                        <span class="font-semibold text-ink">Is it safe to use?</span>
                        <svg :class="open === 3 && 'rotate-180'" class="w-5 h-5 text-ink-quiet transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open === 3" x-collapse>
                        <p class="px-5 pb-5 text-sm text-ink-muted">Yes. This is a read-only server — it can only return VAT rate data and perform calculations. It cannot modify any data, access your files, or perform any actions on your behalf.</p>
                    </div>
                </div>
                <div class="bg-surface rounded-xl border border-line overflow-hidden">
                    <button @click="open = open === 4 ? null : 4" class="w-full flex items-center justify-between p-5 text-left">
                        <span class="font-semibold text-ink">Which AI tools support MCP?</span>
                        <svg :class="open === 4 && 'rotate-180'" class="w-5 h-5 text-ink-quiet transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open === 4" x-collapse>
                        <p class="px-5 pb-5 text-sm text-ink-muted">MCP is supported by VS Code (GitHub Copilot), Cursor, Claude Desktop, Windsurf, and many other AI-powered development tools. Any tool that supports the MCP protocol can connect to this server.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('head')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('mcpPage', () => ({
                showInstall: null,
                mcpUrl: @js($mcpUrl),
                get vscodeConfig() {
                    return JSON.stringify({
                        mcp: {
                            servers: {
                                'eu-vat-info': {
                                    type: 'http',
                                    url: this.mcpUrl
                                }
                            }
                        }
                    }, null, 2);
                },
                get cursorConfig() {
                    return JSON.stringify({
                        mcpServers: {
                            'eu-vat-info': {
                                url: this.mcpUrl
                            }
                        }
                    }, null, 2);
                },
                get claudeConfig() {
                    return JSON.stringify({
                        mcpServers: {
                            'eu-vat-info': {
                                url: this.mcpUrl
                            }
                        }
                    }, null, 2);
                },
                get curlExample() {
                    return `curl -X POST ${this.mcpUrl} \\\n  -H "Content-Type: application/json" \\\n  -d '{\n    "jsonrpc": "2.0",\n    "id": 1,\n    "method": "tools/call",\n    "params": {\n      "name": "get_country_vat_rate",\n      "arguments": {\n        "country": "Germany"\n      }\n    }\n  }'`;
                },
                copyToClipboard(text) {
                    navigator.clipboard.writeText(text);
                }
            }));
        });
    </script>
@endpush
