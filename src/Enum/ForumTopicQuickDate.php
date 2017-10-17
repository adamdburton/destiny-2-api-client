<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

/**
 * Class InvalidForumQuickDate
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_Forum-ForumTopicsQuickDateEnum.html
 */
class ForumTopicQuickDate extends Enum
{
	const All = 0;
	const LastYear = 1;
	const LastMonth = 2;
	const LastWeek = 3;
	const LastDay = 4;
}