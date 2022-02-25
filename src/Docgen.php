<?php

namespace Caendesilva\Docgen;

/**
 * Package Singleton Class
 */
class Docgen
{
    /**
     * Get the name of the documentation site.
     * @return string
     */
    public static function getSiteName(): string
    {
        return config('docgen.siteName', 'dynamic') === 'dynamic' 
            ? config('app.name') . ' Docs'
            : config('docgen.siteName', 'App Name');
    }

    public static function getMarkdownFromSlug(string $slug): string|bool
    {
        try {
            return (string) (new MarkdownConverter(
                file_get_contents(resource_path() . '/docs/' . $slug . '.md')
            )
            )->parse();
        } catch (\Throwable $th) {
            throw $th;
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
            $files[] = $slug;
        }

        return $files;
    }

    public static function validateExistence(string $slug): bool
    {
        return file_exists(resource_path() . '/docs/' . $slug . '.md');
    }

    public static function build()
    {
        // Build the static files
        return new StaticPageBuilder;
    }
}
