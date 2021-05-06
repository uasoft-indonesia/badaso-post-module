<?php

namespace Uasoft\Badaso\Module\Blog\Facades;

use Illuminate\Support\Facades\Facade;

class BadasoBlogModule extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'badaso-blog-module';
    }
}
