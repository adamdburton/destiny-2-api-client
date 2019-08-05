<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

use AdamDBurton\Destiny2ApiClient\Enum;

/**
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_Partnerships-PartnershipType.html
 */
class PartnershipType extends Enum
{
    const None = 0;
    const Twitch = 1;
}