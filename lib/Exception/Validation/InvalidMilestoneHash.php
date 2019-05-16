<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Validation;

class InvalidMilestoneHash extends ValidationException
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid milestone hash.', $value));
	}
}