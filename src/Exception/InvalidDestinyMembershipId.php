<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class InvalidDestinyMembershipId extends \Exception
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid Destiny membership id.', $value));
	}
}