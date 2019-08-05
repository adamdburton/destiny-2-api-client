<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

use AdamDBurton\Destiny2ApiClient\Enum;

/**
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_GroupsV2-RuntimeGroupMemberType.html
 */
class RuntimeGroupMemberType extends Enum
{
    const None = 0;
    const Beginner = 1;
    const Member = 2;
    const Admin = 3;
    const ActingFounder = 4;
    const Founder = 5;
}