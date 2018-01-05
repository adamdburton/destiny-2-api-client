<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

/**
 * Class HostGuidedGamePermission
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_GroupsV2-GroupOptionsEditAction.html
 */
class HostGuidedGamePermission extends Enum
{
	const None = 0;
	const Beginner = 1;
	const Member = 2;
}