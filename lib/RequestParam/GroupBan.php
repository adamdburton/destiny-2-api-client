<?php

namespace AdamDBurton\Destiny2ApiClient\RequestParam;

use AdamDBurton\Destiny2ApiClient\Enum\IgnoreLength;
use AdamDBurton\Destiny2ApiClient\RequestParam;

/**
 * @package AdamDBurton\Destiny2ApiClient\Struct
 */
class GroupBan extends RequestParam
{
    protected $comment = 'string';
    protected $length = IgnoreLength::class;
}