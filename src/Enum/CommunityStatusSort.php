<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

/**
 * Class CommunityStatusSort
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_Community-CommunityStatusSort.html
 */
class CommunityStatusSort extends Enum
{
	const Viewers = 0;
	const Trending = 1;
	const OverallViewers = 2;
	const Followers = 3;
}