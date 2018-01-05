<?php

namespace AdamDBurton\Destiny2ApiClient\Struct;

use AdamDBurton\Destiny2ApiClient\Enum\BungieMembershipType;

class UserMembership extends Struct
{
	protected $membershipType = BungieMembershipType::class;
	protected $membershipId = 'int';
}