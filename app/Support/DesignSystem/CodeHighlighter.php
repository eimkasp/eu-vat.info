<?php

namespace App\Support\DesignSystem;

final class CodeHighlighter
{
    private const PATTERN = '/(?<comment>\{\{--.*?--\}\}|<!--.*?-->)|(?<attribute>(?<=\s)[:@a-zA-Z][\w.:-]*(?==))|(?<blade>\{\{.*?\}\}|\{!!.*?!!\}|@[a-zA-Z]+)|(?<tag><\/?[a-zA-Z][\w.:-]*|\/?>)|(?<string>"[^"]*"|\'[^\']*\')/s';

    /**
     * Escape Blade source and wrap tags, attributes, strings, Blade syntax and comments in the given classes.
     *
     * @param  array{comment: string, attribute: string, blade: string, tag: string, string: string}  $classes
     */
    public static function blade(string $code, array $classes): string
    {
        preg_match_all(self::PATTERN, $code, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE | PREG_UNMATCHED_AS_NULL);

        $html = '';
        $cursor = 0;

        foreach ($matches as $match) {
            [$text, $offset] = $match[0];
            $type = collect(array_keys($classes))->first(fn (string $group) => ($match[$group][0] ?? null) !== null);

            $html .= e(substr($code, $cursor, $offset - $cursor));
            $html .= '<span class="'.$classes[$type].'">'.e($text).'</span>';
            $cursor = $offset + strlen($text);
        }

        return $html.e(substr($code, $cursor));
    }
}
