<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

/**
 * Class Activity
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_Ignores-IgnoreLength.html
 */
class IgnoreLength extends Enum
{
	const None = 0;
	const Week = 1;
	const TwoWeeks = 2;
	const ThreeWeeks = 3;
	const Month = 4;
	const ThreeMonths = 5;
	const SixMonths = 6;
	const Year = 7;
	const Forever = 8;
	const ThreeMinutes = 9;
	const Hour = 10;
	const ThirtyDays = 11;
}