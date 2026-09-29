<?php

use App\Models\Country;
use App\Models\VatRateChange;
use App\Services\ViesValidationService;
use App\Support\Mcp\VatMcpServer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;

beforeEach(function () {
    Cache::flush();

    $this->greece = Country::factory()->create([
        'name' => 'Greece', 'slug' => 'greece', 'iso_code' => 'GR', 'standard_rate' => 24,
        'reduced_rate' => '6 / 13', 'currency_code' => 'EUR',
    ]);
    $this->germany = Country::factory()->create([
        'name' => 'Germany', 'slug' => 'germany', 'iso_code' => 'DE', 'standard_rate' => 19,
        'reduced_rate' => 7, 'currency_code' => 'EUR',
    ]);
});

function mcp(mixed $payload)
{
    return test()->call('POST', '/api/mcp', [], [], [], ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json, text/event-stream'], is_string($payload) ? $payload : json_encode($payload));
}

function mcpTool(string $name, array $arguments = []): array
{
    return mcp(['jsonrpc' => '2.0', 'id' => 7, 'method' => 'tools/call', 'params' => ['name' => $name, 'arguments' => $arguments]])
        ->assertOk()
        ->json('result');
}

it('negotiates the protocol version and introduces the server', function () {
    mcp(['jsonrpc' => '2.0', 'id' => 1, 'method' => 'initialize', 'params' => ['protocolVersion' => '2025-03-26']])
        ->assertOk()
        ->assertJsonPath('result.protocolVersion', '2025-03-26')
        ->assertJsonPath('result.serverInfo.name', 'eu-vat-info')
        ->assertJsonPath('result.serverInfo.title', 'EU VAT Info')
        ->assertJsonPath('result.capabilities.tools.listChanged', false)
        ->assertJsonPath('result.instructions', VatMcpServer::instructions());

    mcp(['jsonrpc' => '2.0', 'id' => 2, 'method' => 'initialize', 'params' => ['protocolVersion' => '1999-01-01']])
        ->assertJsonPath('result.protocolVersion', VatMcpServer::latestProtocolVersion());
});

it('accepts notifications with 202 and answers ping with an empty object', function () {
    mcp(['jsonrpc' => '2.0', 'method' => 'notifications/initialized'])
        ->assertStatus(202)
        ->assertContent('');

    expect(mcp(['jsonrpc' => '2.0', 'id' => 3, 'method' => 'ping'])->getContent())->toContain('"result":{}');
});

it('lists every tool with a title, schema and read-only annotations', function () {
    $tools = collect(mcp(['jsonrpc' => '2.0', 'id' => 4, 'method' => 'tools/list'])->assertOk()->json('result.tools'));

    expect($tools->pluck('name')->all())->toBe(VatMcpServer::toolNames())
        ->and($tools->every(fn (array $tool) => filled($tool['title']) && $tool['inputSchema']['type'] === 'object' && $tool['annotations']['readOnlyHint'] === true))->toBeTrue()
        ->and($tools->firstWhere('name', 'validate_vat_number')['annotations']['openWorldHint'])->toBeTrue()
        ->and($tools->firstWhere('name', 'get_all_vat_rates')['annotations']['openWorldHint'])->toBeFalse();
});

it('returns structured country rates and accepts the EL alias for Greece', function () {
    $result = mcpTool('get_country_vat_rate', ['country' => 'EL']);

    expect($result['isError'])->toBeFalse()
        ->and($result['structuredContent']['country'])->toBe('Greece')
        ->and($result['structuredContent']['currency'])->toBe('EUR')
        ->and($result['structuredContent']['rates']['reduced_rates'])->toEqual([6, 13])
        ->and(json_decode($result['content'][0]['text'], true))->toBe($result['structuredContent']);

    expect(mcpTool('get_country_vat_rate', ['country' => 'Atlantis'])['isError'])->toBeTrue();
});

it('calculates VAT in both directions and rejects bad input as a tool error', function () {
    expect(mcpTool('calculate_vat', ['amount' => 100, 'country' => 'germany'])['structuredContent'])
        ->toMatchArray(['net_amount' => 100.0, 'vat_amount' => 19.0, 'gross_amount' => 119.0, 'currency' => 'EUR']);

    expect(mcpTool('calculate_vat', ['amount' => 119, 'country' => 'DE', 'mode' => 'remove'])['structuredContent'])
        ->toMatchArray(['net_amount' => 100.0, 'vat_amount' => 19.0, 'gross_amount' => 119.0]);

    expect(mcpTool('calculate_vat', ['amount' => 'lots', 'country' => 'DE'])['isError'])->toBeTrue()
        ->and(mcpTool('calculate_vat', ['amount' => 10, 'country' => 'DE', 'rate_type' => 'parking'])['isError'])->toBeTrue()
        ->and(mcpTool('compare_vat_rates', ['countries' => ['DE']])['isError'])->toBeTrue();

    expect(mcpTool('compare_vat_rates', ['countries' => ['DE', 'greece']])['structuredContent']['countries'])->toHaveCount(2);
});

it('lists upcoming rate changes soonest first', function () {
    VatRateChange::factory()->for($this->germany)->create(['change_date' => now()->subYear(), 'rate_type' => 'standard', 'old_rate' => 16, 'new_rate' => 19]);
    VatRateChange::factory()->for($this->germany)->create(['change_date' => now()->addMonths(6), 'rate_type' => 'reduced', 'old_rate' => 7, 'new_rate' => 8]);
    VatRateChange::factory()->for($this->greece)->create(['change_date' => now()->addMonth(), 'rate_type' => 'standard', 'old_rate' => 24, 'new_rate' => 23]);

    $upcoming = mcpTool('get_vat_rate_changes', ['upcoming_only' => true])['structuredContent']['changes'];

    expect(array_column($upcoming, 'country'))->toBe(['Greece', 'Germany'])
        ->and(mcpTool('get_vat_rate_changes', ['country' => 'DE'])['structuredContent']['count'])->toBe(2)
        ->and(mcpTool('get_vat_rate_changes', ['limit' => 1])['structuredContent']['changes'])->toHaveCount(1);
});

it('validates VAT numbers through VIES with a per-client limit', function () {
    $this->mock(ViesValidationService::class)
        ->shouldReceive('validate')
        ->with('DE', '123456789')
        ->times(VatMcpServer::VIES_CHECKS_PER_MINUTE)
        ->andReturn(['valid' => true, 'country_code' => 'DE', 'vat_number' => '123456789', 'name' => 'Example GmbH', 'address' => null, 'source' => 'vies_api']);

    RateLimiter::clear('mcp-vies:127.0.0.1');

    $first = mcpTool('validate_vat_number', ['country_code' => 'de', 'vat_number' => 'DE 123 456 789']);

    expect($first['isError'])->toBeFalse()
        ->and($first['structuredContent'])->toMatchArray(['valid' => true, 'name' => 'Example GmbH'])
        ->and($first['structuredContent'])->not->toHaveKey('address');

    foreach (range(2, VatMcpServer::VIES_CHECKS_PER_MINUTE) as $attempt) {
        mcpTool('validate_vat_number', ['country_code' => 'DE', 'vat_number' => '123456789']);
    }

    $limited = mcpTool('validate_vat_number', ['country_code' => 'DE', 'vat_number' => '123456789']);

    expect($limited['isError'])->toBeTrue()
        ->and($limited['content'][0]['text'])->toContain('Too many VAT number checks');
});

it('answers protocol errors and batches as JSON-RPC', function () {
    mcp(['jsonrpc' => '2.0', 'id' => 8, 'method' => 'tools/call', 'params' => ['name' => 'drop_tables']])
        ->assertJsonPath('error.code', -32602);

    mcp(['jsonrpc' => '2.0', 'id' => 9, 'method' => 'resources/list'])->assertJsonPath('error.code', -32601);
    mcp('{not json')->assertJsonPath('error.code', -32700);
    mcp(['id' => 10, 'method' => 'ping'])->assertJsonPath('error.code', -32600);

    $batch = mcp([
        ['jsonrpc' => '2.0', 'id' => 11, 'method' => 'ping'],
        ['jsonrpc' => '2.0', 'method' => 'notifications/initialized'],
        ['jsonrpc' => '2.0', 'id' => 12, 'method' => 'tools/list'],
    ])->assertOk()->json();

    expect(array_column($batch, 'id'))->toBe([11, 12]);

    $this->get('/api/mcp')->assertStatus(405);
});

it('publishes the same tools in the server card and on the MCP page', function () {
    $card = $this->getJson('/.well-known/mcp/server-card.json')->assertOk();

    expect(array_column($card->json('tools'), 'name'))->toBe(VatMcpServer::toolNames())
        ->and($card->json('transport'))->toBe(['type' => 'streamable-http', 'endpoint' => VatMcpServer::endpoint()])
        ->and($card->json('protocolVersions'))->toBe(VatMcpServer::PROTOCOL_VERSIONS);

    $page = $this->get('/mcp-server')->assertOk()->assertSee(VatMcpServer::endpoint());

    foreach (VatMcpServer::toolNames() as $name) {
        $page->assertSee($name);
    }
});
