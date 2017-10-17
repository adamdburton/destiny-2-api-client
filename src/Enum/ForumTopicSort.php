<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

/**
 * Class InvalidForumQuickDate
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_Forum-ForumTopicsSortEnum.html
 */
class ForumTopicSort extends Enum
{
	const Default = 0;
	const LastReplied = 1;
	const MostReplied = 2;
	const Popularity = 3;
	const Controversiality = 4;
	const Liked = 5;
	const HighestRated = 6;
	const MostUpvoted = 7;
}