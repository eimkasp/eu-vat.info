<?php

namespace App\View\Components;

use Illuminate\Support\HtmlString;
use Illuminate\View\Component;

/**
 * Renders a schema.org JSON-LD block. The "@context" key is added here, in PHP, because writing it
 * inside a Blade template triggers Blade's @context directive and corrupts the structured data.
 */
class JsonLd extends Component
{
    public function __construct(public array $data) {}

    public function render(): HtmlString
    {
        $payload = array_key_exists('@graph', $this->data) || array_is_list($this->data)
            ? ['@context' => 'https://schema.org', '@graph' => $this->data['@graph'] ?? $this->data]
            : ['@context' => 'https://schema.org'] + $this->data;

        $json = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_THROW_ON_ERROR);

        return new HtmlString('<script type="application/ld+json">'.$json.'</script>');
    }
}
