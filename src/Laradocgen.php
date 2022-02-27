<?php

namespace DeSilva\Laradocgen;

/**
 * Package Singleton Class
 */
class Laradocgen
{
    /**
     * Get the Source Path
     *
     * Returns the directory where the source markdown files are stored
     * Usually in <laravel-project>/resources/docs/
     * With media in <laravel-project>/resources/docs/media/
     * 
     * @return string $sourcePath
     **/
    public static function getSourcePath()
    {
        return resource_path('docs' . DIRECTORY_SEPARATOR);
    }

    /**
     * Get the Build Path
     *
     * Returns the directory where the static HTML files are stored once created
     * Usually in <laravel-project>/public/docs/
     * With media in <laravel-project>/public/docs/media/
     * 
     * @return string $buildPath
     **/
    public static function getBuildPath()
    {
        return public_path('docs' . DIRECTORY_SEPARATOR);
    }

    /**
     * Get the path of a file in the source directory
     *
     * Note that the path will be returned regardless if the file exists or not.

     * @example Laradocgen::getSourceFilePath('index.md') returns /home/<user>/<laravel-project>/resources/docs/index.md
     * 
     * @param string $filename to search for
     * @return string|false $filepath the full path
     **/
    public static function getSourceFilePath(string $filename): string
    {
        return self::getSourcePath() . $filename;
    }

    /**
     * Get the contents of a file in the source directory
     *
     * Returns false if the file does not exist
     * 
     * @example Laradocgen::getSourceFileContents('index.md') returns /home/<user>/<laravel-project>/resources/docs/index.md
     *
     * @param string $filename to search for
     * @return string|false $filepath the full path if file exists, else false
     **/
    public static function getSourceFileContents(string $filename): string|false
    {
        return file_get_contents(self::getSourceFilePath($filename));
    }

    

    /**
     * Get the name of the documentation site.
     * Is dynamically generated from the App name unless
     * overridden in the config.
     * 
     * @return string $siteName
     */
    public static function getSiteName(): string
    {
        return empty(config('laradocgen.siteName'))
                ? config('app.name', 'Laravel') . ' Docs'
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
