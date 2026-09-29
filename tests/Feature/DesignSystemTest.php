<?php

use Illuminate\Support\Facades\File;

/*
 * Guards for the rules in DESIGN.md. Every failure names the file, the line and the fix,
 * so the message alone is enough to correct a template.
 */

const LEGACY_INLINE_SVG_VIEWS = [
    'livewire/chrome-extension.blade.php',
    'livewire/donate.blade.php',
    'livewire/vat-validation-api-docs.blade.php',
];

function designSystemViews(): array
{
    return collect(File::allFiles(resource_path('views')))
        ->filter(fn ($file) => str_ends_with($file->getFilename(), '.blade.php'))
        ->map(fn ($file) => str_replace('\\', '/', $file->getRelativePathname()))
        ->reject(fn (string $path) => str_starts_with($path, 'vendor/') || str_starts_with($path, 'amp/'))
        ->sort()
        ->values()
        ->all();
}

function designSystemSource(string $view, bool $withoutPhpBlocks = false): string
{
    $source = file_get_contents(resource_path('views/'.$view));

    if (! $withoutPhpBlocks) {
        return $source;
    }

    return preg_replace_callback('/@php\b.*?@endphp|<\?php.*?\?>/s', fn (array $block) => str_repeat("\n", substr_count($block[0], "\n")), $source);
}

function designSystemViolations(string $pattern, string $fix, array $skip = [], bool $withoutPhpBlocks = false): array
{
    $violations = [];

    foreach (designSystemViews() as $view) {
        if (in_array($view, $skip, true)) {
            continue;
        }

        foreach (explode("\n", designSystemSource($view, $withoutPhpBlocks)) as $index => $line) {
            if (preg_match($pattern, $line, $match)) {
                $violations[] = sprintf('resources/views/%s:%d uses "%s". %s', $view, $index + 1, trim($match[0]), $fix);
            }
        }
    }

    return $violations;
}

it('builds templates from semantic tokens, not the raw Tailwind palette', function () {
    $violations = designSystemViolations(
        '/\b(?:bg|text|border|ring|ring-offset|outline|decoration|divide|placeholder|from|via|to|fill|stroke|caret|accent|shadow)-(?:slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)-\d{2,3}\b/',
        'Use a semantic token such as bg-surface, text-ink-muted, border-line, bg-action-soft, text-success or text-syntax-string.',
    );

    expect($violations)->toBeEmpty(implode("\n", $violations));
});

it('never uses dark: variants because the tokens switch themes', function () {
    $violations = designSystemViolations(
        '/(?<![\w-])dark:[^\s"\'>]+/',
        'Remove the dark: variant and use a token that already has a dark value (see DESIGN.md › Color roles).',
    );

    expect($violations)->toBeEmpty(implode("\n", $violations));
});

it('keeps raw colour values out of classes and inline styles', function () {
    $violations = designSystemViolations(
        '/(?:\b[a-z-]+-\[(?:#|rgb|hsl|oklch|oklab)[^\]]*\]|style="[^"]*(?:#[0-9a-fA-F]{3,8}\b|rgba?\(|hsla?\(|oklch\())/',
        'Add or reuse a token in resources/css/app.css instead of a literal colour.',
    );

    expect($violations)->toBeEmpty(implode("\n", $violations));
});

it('keeps surfaces solid instead of blurred', function () {
    $violations = designSystemViolations(
        '/\bbackdrop-(?:blur|filter|saturate)[\w\[\]\/.-]*/',
        'Surfaces are opaque: use app-surface, app-popover or app-sticky-bar, and scrim behind dialogs.',
    );

    expect($violations)->toBeEmpty(implode("\n", $violations));
});

it('keeps surfaces flat instead of using gradients', function () {
    $violations = designSystemViolations(
        '/(?<![\w-])(?:[a-z]+:)*bg-(?:linear|radial|conic|gradient)-[\w\[\]\/.-]*/',
        'Use a flat token such as bg-brand or bg-surface; the only gradient is the hero-scrim inside <x-hero-backdrop>.',
    );

    expect($violations)->toBeEmpty(implode("\n", $violations));
});

it('uses elevation tokens instead of default Tailwind shadows', function () {
    $violations = designSystemViolations(
        '/(?<![\w-])(?:[a-z]+:)*shadow-(?:2xs|xs|sm|md|lg|xl|2xl|inner)\b/',
        'Use shadow-card, shadow-workflow or shadow-floating (or a component class that includes one).',
    );

    expect($violations)->toBeEmpty(implode("\n", $violations));
});

it('uses the radius scale', function () {
    $violations = designSystemViolations(
        '/(?<![\w-])(?:[a-z]+:)*rounded(?:-(?:t|b|l|r|s|e|tl|tr|bl|br|ss|se|es|ee))?-(?:md|lg|xl|2xl|3xl|4xl|\[[^\]]*\])(?![\w-])/',
        'Use rounded-control (4px), rounded-card (6px) or rounded-panel (8px); rounded-xs or rounded-sm for flags, badges and bar ends.',
    );

    expect($violations)->toBeEmpty(implode("\n", $violations));
});

it('keeps buttons, chips and badges rectangular', function () {
    $violations = [];

    foreach (designSystemViews() as $view) {
        foreach (explode("\n", designSystemSource($view)) as $index => $line) {
            preg_match_all('/"[^"]*"|\'[^\']*\'/', $line, $strings);

            foreach ($strings[0] as $string) {
                if (preg_match('/(?<![\w-])rounded-full(?![\w-])/', $string) && preg_match('/(?<![\w-])(?:[a-z]+:)*px-/', $string)) {
                    $violations[] = sprintf('resources/views/%s:%d makes a pill. Use rounded-control for buttons and chips or app-badge for labels; rounded-full is for dots, spinners and avatars.', $view, $index + 1);
                }
            }
        }
    }

    expect($violations)->toBeEmpty(implode("\n", $violations));
});

it('writes structured data without a raw @context directive', function () {
    $violations = designSystemViolations(
        '/(?<![@\w])@context\b/',
        'Blade treats @context as a directive: use <x-json-ld :data="[...]"> or escape it as @@context.',
        withoutPhpBlocks: true,
    );

    expect($violations)->toBeEmpty(implode("\n", $violations));
});

it('gives every image alternative text', function () {
    $violations = [];

    foreach (designSystemViews() as $view) {
        $source = designSystemSource($view);

        preg_match_all('/<img\b(?:[^>"\']|"[^"]*"|\'[^\']*\')*>/s', $source, $matches, PREG_OFFSET_CAPTURE);

        foreach ($matches[0] as [$tag, $offset]) {
            if (! preg_match('/(?:\s|:)alt=/', $tag)) {
                $violations[] = sprintf('resources/views/%s:%d has an <img> without alt. Add alt="" for decoration or a description.', $view, substr_count(substr($source, 0, $offset), "\n") + 1);
            }
        }
    }

    expect($violations)->toBeEmpty(implode("\n", $violations));
});

it('draws icons through x-ui.icon, with a shrinking list of legacy pages', function () {
    $allowed = ['components/ui/icon.blade.php', 'components/ui/logo.blade.php', ...LEGACY_INLINE_SVG_VIEWS];

    $violations = designSystemViolations(
        '/<svg\b/',
        'Use <x-ui.icon name="…"> and add the path to components/ui/icon.blade.php if it is missing.',
        $allowed,
    );

    $stale = collect(LEGACY_INLINE_SVG_VIEWS)
        ->reject(fn (string $view) => str_contains(file_get_contents(resource_path('views/'.$view)), '<svg'))
        ->map(fn (string $view) => "{$view} no longer has inline SVG: remove it from LEGACY_INLINE_SVG_VIEWS.")
        ->all();

    expect([...$violations, ...$stale])->toBeEmpty(implode("\n", [...$violations, ...$stale]));
});

it('documents every token, utility and component class in DESIGN.md', function () {
    $css = file_get_contents(resource_path('css/app.css'));
    $guide = file_get_contents(base_path('DESIGN.md'));

    preg_match_all('/--ui-([a-z-]+):/', $css, $tokens);
    preg_match_all('/@utility ([a-z-]+)/', $css, $utilities);
    preg_match_all('/^\s*\.(app-[a-z-]+|hero-[a-z-]+)\b/m', $css, $components);
    preg_match_all('/--(radius|shadow|ease|color-syntax)-([a-z-]+):/', $css, $scales);

    $names = collect()
        ->merge($tokens[1])
        ->merge($utilities[1])
        ->merge($components[1])
        ->merge(collect($scales[0])->map(fn (string $declaration) => rtrim(substr($declaration, 2), ':')))
        ->unique()
        ->values();

    $missing = $names->reject(fn (string $name) => str_contains($guide, $name))->all();

    expect($missing)->toBeEmpty('Document these in DESIGN.md: '.implode(', ', $missing));
});
