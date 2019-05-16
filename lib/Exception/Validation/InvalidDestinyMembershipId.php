<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Validation;

class InvalidDestinyMembershipId extends ValidationException
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid Destiny membership id.', $value));
	}
}