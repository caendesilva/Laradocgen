<?php

namespace DeSilva\LaraDocGen;

use Illuminate\Support\Facades\Facade;

/**
 * @see \DeSilva\LaraDocGen\Skeleton\SkeletonClass
 */
class LaraDocGenFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laradocgen';
    }
}
