<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

/**
 * Class Activity
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_Destiny-HistoricalStats-Definitions-DestinyActivityModeType.html
 */
class ActivityType extends Enum
{
	const None = 0;
	const Story = 2;
	const Strike = 3;
	const Raid = 4;
	const AllPvP = 5;
	const Patrol = 6;
	const AllPvE = 7;
	const RESERVED9 = 9;
	const Control = 10;
	const Reserved11 = 11;
	const Clash = 12;
	const Reserved13 = 13;
	const Reserved15 = 15;
	const Nightfall = 16;
	const HeroicNightfall = 17;
	const AllStrikes = 18;
	const IronBanner = 19;
	const Reserved20 = 20;
	const Reserved21 = 21;
	const Reserved22 = 22;
	const Reserved23 = 23;
	const Reserved24 = 24;
	const Reserved25 = 25;
	const Reserved26 = 26;
	const Reserved27 = 27;
	const Reserved28 = 28;
	const Reserved29 = 29;
	const Reserved30 = 30;
	const Supremacy = 31;
	const Reserved32 = 32;
	const Survival = 37;
	const Countdown = 38;
	const TrialsOfTheNine = 39;
	const Social = 40;
}