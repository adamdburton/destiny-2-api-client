<?php

namespace AdamDBurton\Destiny2ApiClient\Struct;

use AdamDBurton\Destiny2ApiClient\Enum\IgnoreLength;

class GroupBanRequest extends Struct
{
	protected $comment = 'string';
	protected $length = IgnoreLength::class;
}