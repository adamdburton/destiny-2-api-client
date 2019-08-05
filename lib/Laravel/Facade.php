<?php

namespace AdamDBurton\Destiny2ApiClient\Laravel;

use Illuminate\Support\Facades\Facade as LaravelFacade;

/**
 * @package AdamDBurton\Destiny2ApiClient\Laravel
 */
class Facade extends LaravelFacade
{
    protected static function getFacadeAccessor()
    {
        return 'destiny';
    }
}