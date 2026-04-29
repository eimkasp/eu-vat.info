<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Changelog extends Component
{
    public array $releases = [];

    public function mount(): void
    {
        $this->releases = Cache::remember('app_changelog', 3600, fn () => $this->parseChangelog());
    }

    private function parseChangelog(): array
    {
        $path = base_path('CHANGELOG.md');

        if (! file_exists($path)) {
            return [];
        }

        $content = file_get_contents($path);
        $releases = [];

        // Split on ## headings (each release)
        $sections = preg_split('/^## /m', $content, -1, PREG_SPLIT_NO_EMPTY);

        foreach ($sections as $section) {
            $lines = explode("\n", trim($section));
            $heading = trim(array_shift($lines));

            // Skip the intro/meta section before the first release
            if (! preg_match('/^\[/', $heading)) {
                continue;
            }

            // Parse "[Version] — Date — Subtitle" or "[Version] — Date"
            if (preg_match('/^\[([^\]]+)\]\s*(?:—|-)\s*(\d{4}-\d{2}-\d{2})(?:\s*(?:—|-)\s*(.+))?$/u', $heading, $m)) {
                $version = $m[1];
                $date = $m[2];
                $subtitle = isset($m[3]) ? trim($m[3]) : null;
            } elseif (preg_match('/^\[([^\]]+)\](?:\s*(?:—|-)\s*(.+))?$/u', $heading, $m)) {
                $version = $m[1];
                $date = null;
                $subtitle = isset($m[2]) ? trim($m[2]) : null;
            } else {
                continue;
            }

            $body = implode("\n", $lines);
            $groups = $this->parseGroups($body);

            $releases[] = [
                'version'  => $version,
                'date'     => $date,
                'subtitle' => $subtitle,
                'groups'   => $groups,
                'slug'     => 'v' . strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $version)),
            ];
        }

        return $releases;
    }

    private function parseGroups(string $body): array
    {
        $groups = [];
        $currentGroup = null;
        $currentItems = [];

        foreach (explode("\n", $body) as $line) {
            // ### Sub-heading = named group (Added, Fixed, Improved, etc.)
            if (preg_match('/^### (.+)$/', $line, $m)) {
                if ($currentGroup !== null) {
                    $groups[] = ['name' => $currentGroup, 'items' => $currentItems];
                }
                $currentGroup = trim($m[1]);
                $currentItems = [];
                continue;
            }

            // #### Sub-sub-heading = label item inside a group (treat as sub-heading)
            if (preg_match('/^#### (.+)$/', $line, $m)) {
                if ($currentGroup === null) {
                    $currentGroup = 'Details';
                }
                $currentItems[] = ['type' => 'heading', 'text' => trim($m[1])];
                continue;
            }

            // Bullet list item
            if (preg_match('/^[-*]\s+(.+)$/', $line, $m)) {
                if ($currentGroup === null) {
                    $currentGroup = 'Changes';
                }
                $currentItems[] = ['type' => 'item', 'text' => trim($m[1])];
                continue;
            }

            // Paragraph text (non-empty, non-table line)
            $trimmed = trim($line);
            if ($trimmed && ! str_starts_with($trimmed, '|') && ! str_starts_with($trimmed, '**Score') && strlen($trimmed) > 5) {
                if ($currentGroup !== null && ! str_starts_with($trimmed, '**')) {
                    // Only collect short descriptive paragraphs, skip tables
                }
            }
        }

        if ($currentGroup !== null) {
            $groups[] = ['name' => $currentGroup, 'items' => $currentItems];
        }

        return $groups;
    }

    public function render()
    {
        return view('livewire.changelog');
    }
}
