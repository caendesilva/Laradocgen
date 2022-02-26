<?php

namespace DeSilva\Laradocgen;

use Illuminate\Support\Facades\Facade;

/**
 * @see \DeSilva\Laradocgen\Skeleton\SkeletonClass
 */
class LaradocgenFacade extends Facade
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
