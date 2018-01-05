<?php

namespace AdamDBurton\Destiny2ApiClient\Struct;

class GroupApplicationListRequest extends Struct
{
	protected $memberships = UserMembership::class . '[]';
	protected $message = 'string';
}