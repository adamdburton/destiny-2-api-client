<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

/**
 * Class CharacterClass
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_Forum-CommunityContentSortMode.html
 */
class CommunityContentSortMode extends Enum
{
	const Trending = 0;
	const Latest = 1;
	const HighestRated = 2;
}