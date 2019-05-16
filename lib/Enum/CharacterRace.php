<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

use AdamDBurton\Destiny2ApiClient\Enum;

/**
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_Destiny-DestinyRace.html
 */
class CharacterRace extends Enum
{
	const Human = 0;
	const Awoken = 1;
	const Exo = 2;
	const Unknown = 3;
}