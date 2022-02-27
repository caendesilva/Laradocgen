<?php

namespace DeSilva\Laradocgen;

use stdClass;
use App\Http\Controllers\Controller;

/**
 * The realtime compiler runs on each request to the live preview.
 * It takes care of copying assets to the public directory on the fly.
 * 
 * Usage 
 * ```php
 * new RealtimeCompiler; // Invokes the compiler automatically
 * ```
 */
class RealtimeCompiler extends Controller
{
    /**
     * @deprecated v0.1.0-dev
     * 
     * @var stdClass
     */
    protected stdClass $appmeta;

    /**
     * Construct the class and run the compiler when the class is created.
     */
    public function __construct()
    {
        $this->appmeta = new \stdClass();

        $this->__invoke();
    }

    /**
     * Run the realtime compiler
     */
    public function __invoke()
    {

    }

    /**
     * Check what metadata should be included
     * 
     * @deprecated v0.1.0-dev
     * 
     * @return void
     */
    public function buildAppmeta(): void
    {
        trigger_error("Use of deprecated method.", E_USER_DEPRECATED);
        return;

        if (file_exists(resource_path() . "/docs/media/custom.css")) {
            $this->appmeta->customStylesheet = true;
        }
    }

    /**
     * Return an object with the meta information about the app.
     * For example what stylesheets to use and what the root URI path is.
     * 
     * @deprecated v0.1.0-dev
     * 
     * @return \stdClass
     */
    public function getAppmeta(): \stdClass
    {
        trigger_error("Use of deprecated method.", E_USER_DEPRECATED);
        
        return $this->appmeta;
    }

    /**
     * Compile the styles and return them.
     * Errors are silenced as it is okay if they are null.
     * 
     * @return string
     */
    public function getStyles(): string
    {
        $styles = @file_get_contents(resource_path('docs/media/app.css'));

        $styles .= @file_get_contents(resource_path('docs/media/custom.css')) ?? null;

        return $styles ?? "";
    }

    /**
     * Return the scripts.
     * Errors are silenced as it is okay if they are null.
     * 
     * @return string
     */
    public function getScripts(): string
    {
        return @file_get_contents(resource_path('docs/media/app.js')) ?? "";
    }


    /**
     * @deprecated v0.1.0-dev
     */
    private function copyAssetsFromResourcesToPublicDirectory()
    {
        trigger_error("Use of deprecated method.", E_USER_DEPRECATED);
        return;

        // Set the source path
        $sourcePath = resource_path() . '/docs/';
        // Set the build path
        $buildPath = public_path() . '/realtime-docs-compiler/';

        // Ensure directory exists
        is_dir($buildPath) || mkdir($buildPath);
        is_dir($buildPath . 'media') || mkdir($buildPath . 'media');

        if (!file_exists($buildPath . 'info.txt')) {
            echo " > Creating info.txt \n";
            file_put_contents($buildPath . 'info.txt', 'This directory serves the content for the Laradocgen Realtime Compiler.
It can safely be deleted, and should not be committed to your source control.
A .gitignore file has been created in this directory.
You may also want to add the following line: "realtime-docs-compiler/"
to the "public\.gitignore" file.');
        }

        if (!file_exists($buildPath . '.gitignore')) {
            echo " > Creating .gitignore \n";
            file_put_contents($buildPath . '.gitignore', '*' . PHP_EOL . '*/' . PHP_EOL . '!.gitignore');
        }

        foreach (glob($sourcePath . "media/*.{png,svg,jpg,jpeg,gif,ico,css}", GLOB_BRACE) as $sourceFilepath) {
            $outputFilepath = $buildPath . 'media/' . basename($sourceFilepath);
            // Check if file exist and if the filesize is changed to prevent unnecessary overwrites.
            if (file_exists($outputFilepath) && filesize($sourceFilepath) == filesize($outputFilepath)) {
                echo " > File " . basename($sourceFilepath) . " with same contents exists. Skipping. \n";
                continue;
            }
            echo " > Copying file " . basename($sourceFilepath) . " to the output media directory \n";
            copy($sourceFilepath, $outputFilepath);
        }
    }
}
