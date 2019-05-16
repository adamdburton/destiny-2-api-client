<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

use AdamDBurton\Destiny2ApiClient\Enum;

/**
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_Forum-ForumPostSortEnum.html
 */
class ForumPostSort extends Enum
{
	const Default = 0;
	const OldestFirst = 1;
}