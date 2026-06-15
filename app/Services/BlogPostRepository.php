<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BlogPostRepository
{
    public function all(): Collection
    {
        if (! File::isDirectory($this->path())) {
            return collect();
        }

        return collect(File::files($this->path()))
            ->filter(fn ($file) => $file->getExtension() === 'md')
            ->map(fn ($file) => $this->parse($file->getPathname()))
            ->filter(fn (array $post) => $post['published'] ?? true)
            ->sortByDesc(fn (array $post) => $post['published_at'])
            ->values();
    }

    public function find(string $slug): ?array
    {
        return $this->all()->firstWhere('slug', $slug);
    }

    public function findOrFail(string $slug): array
    {
        return $this->find($slug) ?? abort(404);
    }

    protected function parse(string $path): array
    {
        $raw = File::get($path);
        $frontMatter = [];
        $content = $raw;

        if (preg_match('/\A---\s*\R(.*?)\R---\s*\R?(.*)\z/s', $raw, $matches)) {
            $frontMatter = $this->parseFrontMatter($matches[1]);
            $content = $matches[2];
        }

        $slug = $frontMatter['slug'] ?? Str::slug(pathinfo($path, PATHINFO_FILENAME));
        $publishedAt = $this->date($frontMatter['published_at'] ?? null);
        $updatedAt = $this->date($frontMatter['updated_at'] ?? $frontMatter['published_at'] ?? null);

        return [
            'title' => $frontMatter['title'] ?? Str::headline($slug),
            'slug' => $slug,
            'description' => $frontMatter['description'] ?? Str::limit(strip_tags($content), 160),
            'published_at' => $publishedAt,
            'updated_at' => $updatedAt,
            'author' => $frontMatter['author'] ?? config('app.name', 'EU VAT Info'),
            'category' => $frontMatter['category'] ?? 'VAT',
            'tags' => $frontMatter['tags'] ?? [],
            'sources' => $frontMatter['sources'] ?? [],
            'content' => trim($content),
            'reading_time' => $this->readingTime($content),
            'path' => $path,
            'published' => $frontMatter['published'] ?? true,
        ];
    }

    protected function path(): string
    {
        return base_path('content/blog');
    }

    protected function parseFrontMatter(string $frontMatter): array
    {
        $data = [];
        $currentList = null;
        $currentMapIndex = null;

        foreach (preg_split('/\R/', $frontMatter) as $line) {
            if (trim($line) === '') {
                continue;
            }

            if (preg_match('/^([A-Za-z0-9_\-]+):(?:\s*(.*))?$/', $line, $matches)) {
                $key = $matches[1];
                $value = $matches[2] ?? '';

                if ($value === '') {
                    $data[$key] = [];
                    $currentList = $key;
                    $currentMapIndex = null;
                } else {
                    $data[$key] = $this->parseFrontMatterValue($value);
                    $currentList = null;
                    $currentMapIndex = null;
                }

                continue;
            }

            if ($currentList && preg_match('/^\s+-\s+(.*)$/', $line, $matches)) {
                $value = $matches[1];

                if (preg_match('/^([A-Za-z0-9_\-]+):\s*(.*)$/', $value, $mapMatches)) {
                    $data[$currentList][] = [
                        $mapMatches[1] => $this->parseFrontMatterValue($mapMatches[2]),
                    ];
                    $currentMapIndex = array_key_last($data[$currentList]);
                } else {
                    $data[$currentList][] = $this->parseFrontMatterValue($value);
                    $currentMapIndex = null;
                }

                continue;
            }

            if ($currentList && $currentMapIndex !== null && preg_match('/^\s+([A-Za-z0-9_\-]+):\s*(.*)$/', $line, $matches)) {
                $data[$currentList][$currentMapIndex][$matches[1]] = $this->parseFrontMatterValue($matches[2]);
            }
        }

        return $data;
    }

    protected function parseFrontMatterValue(string $value): mixed
    {
        $value = trim($value);

        if ($value === '') {
            return '';
        }

        if ($value === 'true') {
            return true;
        }

        if ($value === 'false') {
            return false;
        }

        if ($value === 'null') {
            return null;
        }

        if (str_starts_with($value, '"') && str_ends_with($value, '"')) {
            return str_replace(['\\"', '\\\\'], ['"', '\\'], substr($value, 1, -1));
        }

        if (str_starts_with($value, "'") && str_ends_with($value, "'")) {
            return str_replace("''", "'", substr($value, 1, -1));
        }

        return $value;
    }

    protected function date(mixed $value): CarbonImmutable
    {
        if ($value instanceof \DateTimeInterface) {
            return CarbonImmutable::instance($value);
        }

        return $value ? CarbonImmutable::parse($value) : now()->toImmutable();
    }

    protected function readingTime(string $content): int
    {
        $words = str_word_count(strip_tags($content));

        return max(1, (int) ceil($words / 200));
    }
}
