<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

use AdamDBurton\Destiny2ApiClient\Enum;

/**
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_GroupsV2-GroupType.html
 */
class GroupType extends Enum
{
    const General = 0;
    const Clan = 1;
}