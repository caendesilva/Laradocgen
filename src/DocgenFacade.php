<?php

namespace DeSilva\Docgen;

use Illuminate\Support\Facades\Facade;

/**
 * @see \DeSilva\Docgen\Skeleton\SkeletonClass
 */
class DocgenFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'docgen';
    }
}
