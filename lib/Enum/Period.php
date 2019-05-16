<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

use AdamDBurton\Destiny2ApiClient\Enum;

/**
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_Destiny-HistoricalStats-Definitions-PeriodType.html
 */
class Period extends Enum
{
	const None = 0;
	const Daily = 1;
	const AllTime = 2;
	const Activity = 3;
}