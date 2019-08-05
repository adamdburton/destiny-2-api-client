<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

use AdamDBurton\Destiny2ApiClient\Enum;

/**
 * @package AdamDBurton\Destiny2ApiClient\Enum
 * @see https://bungie-net.github.io/multi/schema_GroupsV2-GroupSortBy.html
 */
class GroupSortBy extends Enum
{
    const Name = 0;
    const Date = 1;
    const Popularity = 2;
    const Id = 3;
}