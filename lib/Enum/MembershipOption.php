<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

use AdamDBurton\Destiny2ApiClient\Enum;

/**
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_GroupsV2-MembershipOption.html
 */
class MembershipOption extends Enum
{
    const Reviewed = 0;
    const Open = 1;
    const Closed = 2;
}