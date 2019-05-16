<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

use AdamDBurton\Destiny2ApiClient\Enum;

/**
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_BungieMembershipType.html
 */
class MembershipType extends Enum
{
	const None = 0;
	const TigerXbox = 1;
	const TigerPsn = 2;
	const TigerBlizzard = 4;
	const TigerDemon = 10;
	const BungieNext = 254;
	const All = -1;

	protected $labels = [
	    'None' => 'None',
	    'TigerXbox' => 'Xbox',
	    'TigerPsn' => 'PSN',
	    'TigerBlizzard' => 'PC',
	    'TigerDemon' => 'Unknown',
	    'BungieNext' => 'Unknown',
	    'All' => 'All'
    ];
}