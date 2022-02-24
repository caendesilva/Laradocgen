<?php

namespace Caendesilva\Docgen;

use GrahamCampbell\Markdown\Facades\Markdown;

class Docgen
{
    public static function getMarkdownFromSlug(string $slug): string|bool {
        try {
            return (string) Markdown::convertToHtml(file_get_contents(resource_path() . '/docs/' . $slug . '.md'));
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function getMarkdownFromSlugOrFail(string $slug): string
    {
        $markdown = self::getMarkdownFromSlug($slug);
        if ($markdown) {
            return $markdown;
        }
        abort(404);
    }

    public static function getMarkdownFileSlugsArray(): array
    {
        $files = [];
    
        foreach (glob(resource_path() . '/docs/*.md') as $filepath) {
            $slug = basename($filepath, '.md');
            // In future we check if in the index if the slug has an order, and if so we set the order as the array index key
            $files[] = $slug;
        }

        return $files;
    }

    public static function build()
    {
        // Build the static files
        return new StaticPageBuilder;
    }
}
