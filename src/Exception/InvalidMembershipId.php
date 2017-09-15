<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class InvalidMembershipId extends \Exception
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid membership id.', $value));
	}
}