<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Validation;

class InvalidMembershipId extends ValidationException
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid membership id.', $value));
	}
}