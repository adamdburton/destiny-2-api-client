<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

use AdamDBurton\Destiny2ApiClient\Enum;

/**
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_Destiny-HistoricalStats-Definitions-DestinyStatsGroupType.html
 */
class StatsGroup extends Enum
{
	const None = 0;
	const General = 1;
	const Weapons = 2;
	const Medals = 3;
	const ReservedGroups = 100;
	const Leaderboard = 101;
	const Activity = 102;
	const UniqueWeapon = 103;
	const Internal = 104;
}