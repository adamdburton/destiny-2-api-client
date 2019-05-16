<?php

namespace AdamDBurton\Destiny2ApiClient\Laravel;

use Illuminate\Support\Facades\Facade as LaravelFacade;

class Facade extends LaravelFacade
{
    protected static function getFacadeAccessor()
    {
        return 'destiny';
    }
}