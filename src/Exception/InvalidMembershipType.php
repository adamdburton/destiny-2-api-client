<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class InvalidMembershipType extends Destiny2ApiException
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid membership type.', $value));
	}
}