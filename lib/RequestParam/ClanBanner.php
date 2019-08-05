<?php

namespace AdamDBurton\Destiny2ApiClient\RequestParam;

use AdamDBurton\Destiny2ApiClient\RequestParam;

/**
 * @package AdamDBurton\Destiny2ApiClient\Struct
 */
class ClanBanner extends RequestParam
{
    protected $decalId = 'int';
    protected $decalColorId = 'int';
    protected $decalBackgroundColorId = 'int';
    protected $gonfalonId = 'int';
    protected $gonfalonColorId = 'int';
    protected $gonfalonDetailId = 'int';
    protected $gonfalonDetailColorId = 'int';
}