<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

/**
 * Class Membership
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_BungieMembershipType.html
 */
class Membership extends Enum
{
	const None = 0;
	const TigerXbox = 1;
	const TigerPsn = 2;
	const TigerBlizzard = 4;
	const TigerDemon = 10;
	const BungieNext = 254;
	const All = -1;
}