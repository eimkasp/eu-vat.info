<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Yaml\Yaml;

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
            $frontMatter = Yaml::parse($matches[1]) ?? [];
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
