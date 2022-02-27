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
     * Construct the class and run the compiler when the class is created.
     */
    public function __construct()
    {
        $this->__invoke();
    }

    /**
     * Run the realtime compiler
     */
    public function __invoke()
    {
        //
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
}
