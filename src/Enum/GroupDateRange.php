<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

/**
 * Class InvalidForumQuickDate
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_GroupsV2-GroupDateRange.html
 */
class GroupDateRange extends Enum
{
	const All = 0;
	const LastDay = 1;
	const LastWeek = 2;
	const LastMonth = 3;
	const LastYear = 4;
}