<?php

namespace DeSilva\Laradocgen;

use Exception;

/**
 * Package Singleton Class.
 *
 * Bootstraps the application services and serves as an interface to the configuration
 *
 * Accessible through the facade
 * @see LaradocgenFacade
 */
class Laradocgen
{
    /**
     * Get the name of the documentation site.
     *
     * Is dynamically generated from the App name
     * unless overridden in the config.
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
     * Get the Source Path.
     *
     * @see PathController::getSourcePath()
     * @return string $sourcePath
     **/
    public static function getSourcePath(): string
    {
        return (new PathController())->sourcePath;
    }

    /**
     * Get the Build Path.
     *
     * Returns the directory where the static HTML files are stored once created
     * Usually in <laravel-project>/public/docs/
     *
     * @see PathController::getBuildPath()
     * @return string $buildPath
     **/
    public static function getBuildPath(): string
    {
        return (new PathController())->buildPath;
    }

    /**
     * Get the path of a file in the source directory.
     *
     * @example Laradocgen::getSourceFilepath('index.md')
     *              returns /home/user/laravel-project/resources/docs/index.md
     *
     * @param  string      $filename  to retrieve
     * @param  string|null $directory optionally specify a subdirectory of the file
     * @return string $filepath full path to the file
     **/
    public static function getSourceFilepath(string $filename, ?string $directory = null): string
    {
        if ($directory) {
            // @todo add validation/sanitation to remove slashes in start and end of string
            $directory = $directory . DIRECTORY_SEPARATOR;
        }
        return self::getSourcePath() . ($directory ?? '') . $filename;
    }

    /**
     * Get the path of a file in the build directory.
     *
     * @example Laradocgen::getBuildFilepath('index.md')
     *              returns /home/user/laravel-project/public/docs/index.md
     *
     * @param  string      $filename  to retrieve
     * @param  string|null $directory optionally specify a subdirectory of the file
     * @return string $filepath full path to the file
     **/
    public static function getBuildFilepath(string $filename, ?string $directory = null): string
    {
        if ($directory) {
            // @todo add validation/sanitation to remove slashes in start and end of string
            $directory = $directory . DIRECTORY_SEPARATOR;
        }
        return self::getBuildPath() . ($directory ?? '') . $filename;
    }

    /**
     * Get the contents of a file in the source directory.
     *
     * Returns false if the file does not exist
     *
     * @example RealtimeCompiler::getStyles()
     *
     * @param  string $filename to search for
     * @return string|false $filepath the full path if file exists, else false
     **/
    public static function getSourceFileContents(string $filename): string|false
    {
        if (!file_exists(self::getSourceFilepath($filename))) {
            return false;
        }
        return file_get_contents(self::getSourceFilepath($filename));
    }

    /**
     * Get an array of all the markdown files
     *
     * Returns the markdown files in the source directory as slugs (without the extension)
     *
     * @return array
     */
    public static function getMarkdownFileSlugsArray(): array
    {
        $files = [];
        foreach (glob(self::getSourceFilepath('*.md')) as $filepath) {
            $slug = basename($filepath, '.md');
            $files[] = $slug;
        }

        return $files;
    }

    /**
     * @param  string $slug
     * @return bool
     */
    public static function validateExistenceOfSlug(string $slug): bool
    {
        return file_exists(self::getSourceFilepath($slug . '.md'));
    }

    /**
     * Check if the necessary files to build the site exists.
     *
     * @todo Automatically generate files based on stubs
     *
     * @returns void
     * @throws Exception if a required file is missing
     **/
    public static function validateSourceFiles(): void
    {
        // The required files, relative to the getSourcePath
        $requiredSourceFilesArray = [
            'index.md',
            '404.md',
            'linkIndex.yml',
            'media/app.css',
            'media/app.js',
        ];

        // Array of the missing files, so we can output them all to the error
        $missingFilesArray = [];
        foreach ($requiredSourceFilesArray as $relativePath) {
            if (!file_exists(self::getSourceFilepath($relativePath))) {
                $missingFilesArray[] = $relativePath;
            }
        }

        if (sizeof($missingFilesArray)) {
            throw new Exception(
                "Required file". (sizeof($missingFilesArray) > 1 ? "s" : '') ." " .
                implode(', ', $missingFilesArray) . " could not be found." .
                " Did you publish the assets?"
            );
        }
    }

    /**
     * Build the static website files.
     *
     * Start the build process by invoking the page builder class
     *
     * @return StaticPageBuilder
     */
    public static function build(): StaticPageBuilder
    {
        return new StaticPageBuilder;
    }
}
