<?php

namespace App\Support\DesignSystem;

final class DesignGuide
{
    /** @var array<int, string> */
    private array $lines;

    public function __construct(private readonly string $markdown)
    {
        $this->lines = explode("\n", str_replace("\r\n", "\n", $markdown));
    }

    public static function fromRepository(): self
    {
        static $instances = [];

        $path = base_path('DESIGN.md');
        $key = $path.':'.filemtime($path);

        return $instances[$key] ??= new self(file_get_contents($path));
    }

    public function markdown(): string
    {
        return $this->markdown;
    }

    public function version(): string
    {
        return $this->frontmatter()['version'] ?? '';
    }

    /**
     * The typography scale from the front matter, keyed by role.
     *
     * @return array<string, array<string, string>>
     */
    public function typeScale(): array
    {
        return collect($this->frontmatter())
            ->filter(fn (mixed $value, string $key) => str_starts_with($key, 'typography.') && is_array($value))
            ->mapWithKeys(fn (array $value, string $key) => [substr($key, 11) => $value])
            ->all();
    }

    /**
     * The markdown under a heading, up to the next heading of the same or a higher level.
     */
    public function section(string $heading): string
    {
        $start = null;
        $level = 0;
        $body = [];

        foreach ($this->lines as $line) {
            if (preg_match('/^(#{1,6})\s+(.+?)\s*$/', $line, $match)) {
                if ($start !== null && strlen($match[1]) <= $level) {
                    break;
                }

                if ($start === null && strcasecmp($match[2], $heading) === 0) {
                    $start = true;
                    $level = strlen($match[1]);

                    continue;
                }
            }

            if ($start !== null) {
                $body[] = $line;
            }
        }

        return trim(implode("\n", $body));
    }

    /**
     * The first table under a heading, as rows keyed by the column headings.
     *
     * @return array<int, array<string, string>>
     */
    public function table(string $heading): array
    {
        return $this->tables($heading)[0] ?? [];
    }

    /**
     * Every table under a heading, each as rows keyed by its column headings.
     *
     * @return array<int, array<int, array<string, string>>>
     */
    public function tables(string $heading): array
    {
        $tables = [];
        $current = [];

        foreach ([...explode("\n", $this->section($heading)), ''] as $line) {
            if (str_starts_with(trim($line), '|')) {
                $current[] = array_map('trim', explode('|', trim(trim($line), '|')));

                continue;
            }

            if (count($current) >= 3) {
                $columns = $current[0];
                $tables[] = array_map(
                    fn (array $cells) => array_combine($columns, array_pad(array_slice($cells, 0, count($columns)), count($columns), '')),
                    array_slice($current, 2),
                );
            }

            $current = [];
        }

        return $tables;
    }

    /**
     * The items of the first numbered list under a heading, with wrapped lines joined.
     *
     * @return array<int, string>
     */
    public function numberedList(string $heading): array
    {
        $items = [];

        foreach (explode("\n", $this->section($heading)) as $line) {
            if (preg_match('/^\d+\.\s+(.*)$/', $line, $match)) {
                $items[] = $match[1];
            } elseif ($items !== [] && preg_match('/^\s{2,}\S/', $line)) {
                $items[array_key_last($items)] .= ' '.trim($line);
            } elseif ($items !== [] && trim($line) !== '') {
                break;
            }
        }

        return $items;
    }

    /**
     * Fenced code blocks under a heading.
     *
     * @return array<int, string>
     */
    public function codeBlocks(string $heading): array
    {
        preg_match_all('/```[a-z]*\n(.*?)\n```/s', $this->section($heading), $matches);

        return $matches[1];
    }

    /**
     * Descriptions from a token table, keyed by the first code span of the first column.
     *
     * @return array<string, array<string, string>>
     */
    public function tokenRows(string $heading): array
    {
        return collect($this->tables($heading))
            ->collapse()
            ->flatMap(function (array $row) {
                preg_match_all('/`([^`]+)`/', (string) reset($row), $names);

                return collect($names[1])->mapWithKeys(fn (string $name) => [ltrim($name, '-') => $row]);
            })
            ->all();
    }

    /**
     * Flat key-value pairs from the YAML front matter, with inline maps expanded one level.
     *
     * @return array<string, mixed>
     */
    private function frontmatter(): array
    {
        if (! preg_match('/\A---\n(.*?)\n---/s', $this->markdown, $match)) {
            return [];
        }

        $values = [];
        $parent = null;

        foreach (explode("\n", $match[1]) as $line) {
            if (! preg_match('/^(\s*)([A-Za-z-]+):\s*(.*)$/', $line, $pair)) {
                continue;
            }

            $key = $pair[1] === '' ? $pair[2] : $parent.'.'.$pair[2];
            $parent = $pair[1] === '' ? $pair[2] : $parent;
            $raw = trim($pair[3]);

            if (preg_match('/^\{(.*)\}$/', $raw, $inline)) {
                $values[$key] = collect(explode(',', $inline[1]))
                    ->map(fn (string $entry) => array_map(fn (string $part) => trim($part, " \"'"), explode(':', $entry, 2)))
                    ->filter(fn (array $entry) => count($entry) === 2)
                    ->mapWithKeys(fn (array $entry) => [$entry[0] => $entry[1]])
                    ->all();
            } elseif ($raw !== '') {
                $values[$key] = trim($raw, "\"'");
            }
        }

        return $values;
    }
}
