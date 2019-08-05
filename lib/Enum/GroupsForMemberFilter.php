<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

use AdamDBurton\Destiny2ApiClient\Enum;

/**
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_GroupsV2-GroupsForMemberFilter.html
 */
class GroupsForMemberFilter extends Enum
{
    const All = 0;
    const Founded = 1;
    const NonFounded = 2;
}