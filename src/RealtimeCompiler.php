<?php

namespace DeSilva\Laradocgen;

use App\Http\Controllers\Controller;

/**
 * RealtimeCompiler Class
 * 
 * The realtime compiler runs on each request to the live preview.
 * Its most important job is to inject the stylesheets and scripts.
 *
 * Usage
 * ```php
 * $compiler = new RealtimeCompiler; // Create the compiler object
 * 
 * $compiler->getStyles(); // Compile and get the styles as an inline string 
 * $compiler->getScripts(); // Get the scripts as an inline string 
 * ```
 * 
 * @uses Laradocgen
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
     * Run the realtime compiler.
     */
    public function __invoke()
    {
        //
    }

    /**
     * Compile the styles and return them.
     *
     * @return string of inline styles
     */
    public function getStyles(): string
    {
        $styles = Laradocgen::getSourceFileContents('media/app.css');
        $styles .= Laradocgen::getSourceFileContents('media/custom.css');

        return $styles ?? "";
    }

    /**
     * Return the scripts.
     *
     * @return string of inline scripts
     */
    public function getScripts(): string
    {
        return Laradocgen::getSourceFileContents('media/app.js') ?? "";
    }
}
