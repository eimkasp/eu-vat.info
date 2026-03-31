<?php

namespace App\Livewire;

use Livewire\Component;

class McpServer extends Component
{
    public string $mcpUrl;

    public function mount()
    {
        $this->mcpUrl = url('/api/mcp');
    }

    public function render()
    {
        return view('livewire.mcp-server');
    }
}
