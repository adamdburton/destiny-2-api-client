<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class InvalidMilestoneHash extends \Exception
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid milestone hash.', $value));
	}
}