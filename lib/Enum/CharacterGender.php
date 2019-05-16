<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

use AdamDBurton\Destiny2ApiClient\Enum;

/**
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_Destiny-DestinyGender.html
 */
class CharacterGender extends Enum
{
	const Male = 0;
	const Female = 1;
	const Unknown = 2;
}