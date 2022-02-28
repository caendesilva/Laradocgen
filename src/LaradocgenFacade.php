<?php

namespace DeSilva\Laradocgen;

use Illuminate\Support\Facades\Facade;

/**
 * Facade Accessor for Laradocgen.
 * @see \DeSilva\Laradocgen\Laradocgen
 *
 * @method string getSiteName()
 * @method string getSourcePath()
 * @method string getBuildPath()
 * @method string getSourceFilepath()
 * @method string getBuildFilepath()
 * @method string|false getSourceFileContents()
 * @method array getMarkdownFileSlugsArray()
 * @method bool validateExistenceOfSlug()
 * @method void validateSourceFiles()
 * @method StaticPageBuilder build()
 */
class LaradocgenFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laradocgen';
    }
}
