<?php

namespace AdamDBurton\Destiny2ApiClient\RequestParam;

use AdamDBurton\Destiny2ApiClient\Enum\BungieMembershipType;
use AdamDBurton\Destiny2ApiClient\RequestParam;

/**
 * @package AdamDBurton\Destiny2ApiClient\RequestParam
 */
class UserMembership extends RequestParam
{
    protected $membershipType = BungieMembershipType::class;
    protected $membershipId = 'int';
}