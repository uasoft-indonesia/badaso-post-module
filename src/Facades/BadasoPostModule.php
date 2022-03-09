<?php

namespace Uasoft\Badaso\Module\Post\Facades;

use Illuminate\Support\Facades\Facade;

class BadasoPostModule extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'badaso-post-module';
    }
}
