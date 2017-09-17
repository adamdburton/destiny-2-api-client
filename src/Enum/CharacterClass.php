<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

/**
 * Class CharacterClass
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_Destiny-DestinyGender.html
 */
class CharacterClass extends Enum
{
	const Titan = 0;
	const Hunter = 1;
	const Warlock = 2;
	const Unknown = 3;
}