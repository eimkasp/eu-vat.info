<?php

namespace App\Livewire;

use App\Support\Mcp\VatMcpServer;
use Livewire\Component;

class McpServer extends Component
{
    public function render()
    {
        return view('livewire.mcp-server', [
            'endpoint' => VatMcpServer::endpoint(),
            'tools' => VatMcpServer::tools(),
            'protocolVersions' => VatMcpServer::PROTOCOL_VERSIONS,
            'examples' => [
                'initialize' => ['jsonrpc' => '2.0', 'id' => 1, 'method' => 'initialize', 'params' => [
                    'protocolVersion' => VatMcpServer::latestProtocolVersion(),
                    'capabilities' => (object) [],
                    'clientInfo' => ['name' => 'browser', 'version' => '1.0.0'],
                ]],
                'list' => ['jsonrpc' => '2.0', 'id' => 2, 'method' => 'tools/list'],
                'call' => ['jsonrpc' => '2.0', 'id' => 3, 'method' => 'tools/call', 'params' => [
                    'name' => 'calculate_vat',
                    'arguments' => ['amount' => 100, 'country' => 'DE', 'mode' => 'add'],
                ]],
            ],
        ]);
    }
}
