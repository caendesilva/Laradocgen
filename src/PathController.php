<?php

namespace DeSilva\Laradocgen;

use Illuminate\Support\Facades\Log;

/**
 * Handles, validates, and assembles the paths used for I/O.
 */
class PathController
{
    /**
     * Document Source Path
     *
     * The directory where the source Markdown files are stored (relative to the Laravel root)
     *
     * The default directory is <laravel-project>/resources/docs/
     * With media stored in <laravel-project>/resources/docs/media/
     */
    public string $sourcePath;

    /**
     * HTML Build Path
     *
     * The directory where the compiled HTML is output (relative to the Laravel root)
     *
     * The default directory is <laravel-project>/public/docs/
     */
    public string $buildPath;

    public function __construct()
    {
        $this->sourcePath = $this->getSourcePath();
        $this->buildPath = $this->getBuildPath();

        if (config('laradocgen.enableAbsolutePathOverride', false) === true) {
            $this->resolveAbsolutePaths();
        }
    }

    /**
     * Get the Source Path.
     *
     * Retrieves the source path from the config, or falls back to the default.
     * It returns an absolute path not ending in a directory separator.
     *
     * @see Laradocgen::getSourcePath()
     * @return string
     */
    private function getSourcePath(): string
    {
        return $this->assembleAbsolutePath(
            $this->sanitizeRelativePath(
                config('laradocgen.sourcePath', 'resources/docs')
            )
        );
    }

    /**
     * Get the Build Path.
     *
     * Retrieves the build path from the config, or falls back to the default.
     * It returns an absolute path not ending in a directory separator.
     *
     * @see Laradocgen::getBuildPath()
     * @return string
     */
    private function getBuildPath(): string
    {
        return $this->assembleAbsolutePath(
            $this->sanitizeRelativePath(
                config('laradocgen.buildPath', 'public/docs')
            )
        );
    }

    /**
     * Sanitize relative path.
     *
     * Sanitizes by ensuring the string does not start or end with a slash
     * and that it does not point to an outside directory.
     *
     * @param string $path a path relative to the Laravel installation to sanitize
     * @return string the path without directory separators in the beginning and end
     */
    private function sanitizeRelativePath(string $path): string
    {
        // Replace directory separators from beginning and end for a more predictable state
        $sanitizedPath = trim($path, '/\\');
        // Replace possible directory separators with the system separator
        $sanitizedPath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $sanitizedPath);
        // To prevent accidental file deletions we make sure that we stay in the Laravel directory
        $sanitizedPath = str_replace(['../', '..\\'], '', $sanitizedPath);

        // Return the sanitized path
        return $sanitizedPath;
    }

    /**
     * Construct an absolute path from a pre-sanitized relative path.
     *
     * @param string $sanitizedPath
     * @return string an absolute path to the specified directory within the Laravel installation
     */
    private function assembleAbsolutePath(string $sanitizedPath): string
    {
        return base_path() . DIRECTORY_SEPARATOR . $sanitizedPath . DIRECTORY_SEPARATOR;
    }

    /**
     * Set the paths to absolute paths, if enabled in config.
     *
     * @return void
     */
    private function resolveAbsolutePaths(): void
    {
        Log::warning('Using absolute paths to build documentation. I hope you know what you are doing!');

        $this->sourcePath = config('laradocgen.absoluteSourcePath');
        $this->buildPath = config('laradocgen.absoluteBuildPath');
    }

}
