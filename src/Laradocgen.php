<?php

namespace DeSilva\Laradocgen;

/**
 * Package Singleton Class
 */
class Laradocgen
{
    /**
     * Get the name of the documentation site.
     *
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
     * Get the Source Path
     *
     * Returns the directory where the source markdown files are stored
     * Usually in <laravel-project>/resources/docs/
     * With media in <laravel-project>/resources/docs/media/
     *
     * @example StaticPageBuilder::__construct()
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
     * Get the path of a file in the source directory.
     *
     * @example Laradocgen::getSourceFilepath('index.md')
     *              returns /home/user/laravel-project/resources/docs/index.md
     *
     * @param  string      $filename  to retrieve
     * @param  string|null $directory optionally specify a subdirectory of the fille
     * @return string|false $filepath full path to the file
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
     * @param  string|null $directory optionally specify a subdirectory of the fille
     * @return string|false $filepath full path to the file
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


    public static function getMarkdownFileSlugsArray(): array
    {
        $files = [];

        foreach (glob(resource_path() . '/docs/*.md') as $filepath) {
            $slug = basename($filepath, '.md');
            $files[] = $slug;
        }

        return $files;
    }

    /**
     * @deprecated use validateExistenceOfSlug instead
     *
     * @param  string $slug
     * @return bool
     */
    public static function validateExistence(string $slug): bool
    {
        return file_exists(resource_path() . '/docs/' . $slug . '.md');
    }

    /**
     * @param  string $slug
     * @return bool
     */
    public static function validateExistenceOfSlug(string $slug): bool
    {
        return file_exists(resource_path() . '/docs/' . $slug . '.md');
    }

    /**
     * Check if the necessary files to build the site exists
     *
     * @todo Automatically generate files based on stubs
     *
     * @throws \Exception
     **/
    public static function validateSourceFiles()
    {
        /**
         * The required files, relative to the getSourcePath DIRECTORY_SEPARATOR
         */
        $requiredSourceFilesArray = [
            'index.md',
            '404.md',
            'linkIndex.yml',
            'media/app.css',
            'media/app.js',
        ];

        // Array of the missing files so we can output them all to the error
        $missingFilesArray = [];
        foreach ($requiredSourceFilesArray as $relativePath) {
            if (!file_exists(self::getSourceFilepath($relativePath))) {
                $missingFilesArray[] = $relativePath;
            }
        }

        if (sizeof($missingFilesArray)) {
            throw new \Exception(
                "Required file". (sizeof($missingFilesArray) > 1 ? "s" : '') ." " .
                implode(', ', $missingFilesArray) . " could not be found." .
                " Did you publish the assets?"
            );
        }
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
