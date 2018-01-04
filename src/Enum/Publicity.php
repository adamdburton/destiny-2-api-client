<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

/**
 * Class InvalidForumQuickDate
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_GroupsV2-GroupEditAction.html
 */
class Publicity extends Enum
{
	const Public = 0;
	const Alliance = 1;
	const Private = 2;
}