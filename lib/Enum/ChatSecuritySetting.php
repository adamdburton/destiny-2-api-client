<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

use AdamDBurton\Destiny2ApiClient\Enum;

/**
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_GroupsV2-ChatSecuritySetting.html
 */
class ChatSecuritySetting extends Enum
{
    const Group = 0;
    const Admins = 1;
}