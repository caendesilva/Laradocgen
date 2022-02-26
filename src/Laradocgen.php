<?php

namespace DeSilva\Laradocgen;

/**
 * Package Singleton Class
 */
class Laradocgen
{
    /**
     * Get the name of the documentation site.
     * @return string
     */
    public static function getSiteName(): string
    {
        return config('laradocgen.siteName', 'dynamic') === 'dynamic'
            ? config('app.name') . ' Docs'
            : config('laradocgen.siteName', 'App Name');
    }

    /**
     * @deprecated and will be renamed as it does not fetch Markdown, but HTML.
     *      Thus it should be renamed to be more semantic.
     *
     * @param string $slug
     * @return string
     */
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

    /**
     * @deprecated and will be removed as we handle 404s differently,
     *              and the self::getMarkdownFromSlug() is also deprecated.
     *
     * @param string $slug
     * @return string
     */
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

    /**
     * Build the static files
     *
     * @return StaticPageBuilder
     */
    public static function build()
    {
        return new StaticPageBuilder;
    }
}
