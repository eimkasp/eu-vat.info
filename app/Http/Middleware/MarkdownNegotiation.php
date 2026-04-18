<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use League\HTMLToMarkdown\HtmlConverter;
use Symfony\Component\HttpFoundation\Response;

class MarkdownNegotiation
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $this->wantsMarkdown($request)) {
            return $response;
        }

        if (! $response->headers->has('Content-Type')
            || ! str_contains($response->headers->get('Content-Type'), 'text/html')) {
            return $response;
        }

        $html = $response->getContent();

        $markdown = $this->convertToMarkdown($html);

        $response->setContent($markdown);
        $response->headers->set('Content-Type', 'text/markdown; charset=utf-8');
        $response->headers->set('Vary', 'Accept');

        $tokenEstimate = $this->estimateTokens($markdown);
        $response->headers->set('x-markdown-tokens', (string) $tokenEstimate);

        return $response;
    }

    protected function wantsMarkdown(Request $request): bool
    {
        $accept = $request->header('Accept', '');

        return str_contains($accept, 'text/markdown');
    }

    protected function convertToMarkdown(string $html): string
    {
        // Extract <main> content to skip nav/header/footer chrome
        $mainContent = $html;
        if (preg_match('/<main[^>]*>(.*?)<\/main>/s', $html, $matches)) {
            $mainContent = $matches[1];
        }

        // Extract page title from <title> tag
        $title = '';
        if (preg_match('/<title[^>]*>(.*?)<\/title>/s', $html, $matches)) {
            $title = html_entity_decode(trim($matches[1]), ENT_QUOTES, 'UTF-8');
        }

        // Extract meta description
        $description = '';
        if (preg_match('/<meta\s+name=["\']description["\']\s+content=["\'](.*?)["\']/si', $html, $matches)) {
            $description = html_entity_decode(trim($matches[1]), ENT_QUOTES, 'UTF-8');
        }

        // Strip script and style tags from main content
        $mainContent = preg_replace('/<script\b[^>]*>.*?<\/script>/si', '', $mainContent);
        $mainContent = preg_replace('/<style\b[^>]*>.*?<\/style>/si', '', $mainContent);

        // Strip SVG elements
        $mainContent = preg_replace('/<svg\b[^>]*>.*?<\/svg>/si', '', $mainContent);

        // Strip Livewire wire: attributes to clean up output
        $mainContent = preg_replace('/\s*wire:[a-z.]+="[^"]*"/i', '', $mainContent);

        $converter = new HtmlConverter([
            'strip_tags' => true,
            'hard_break' => true,
            'remove_nodes' => 'script style svg nav',
        ]);

        $markdown = $converter->convert($mainContent);

        // Clean up excessive blank lines
        $markdown = preg_replace("/\n{3,}/", "\n\n", $markdown);

        // Build front-matter-style header
        $header = '';
        if ($title) {
            $header .= "---\ntitle: {$title}\n";
            if ($description) {
                $header .= "description: {$description}\n";
            }
            $header .= "---\n\n";
        }

        return $header . trim($markdown) . "\n";
    }

    protected function estimateTokens(string $text): int
    {
        // Rough estimate: ~4 characters per token (GPT-style tokenizers)
        return (int) ceil(mb_strlen($text) / 4);
    }
}
