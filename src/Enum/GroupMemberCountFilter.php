<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

/**
 * Class InvalidForumQuickDate
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_GroupsV2-GroupQuery.html#schema_GroupsV2-GroupQuery
 */
class GroupMemberCountFilter extends Enum
{
	const All = 0;
	const OneToTen = 1;
	const ElevenToOneHundred = 2;
	const GreaterThanOneHundred = 3;
}