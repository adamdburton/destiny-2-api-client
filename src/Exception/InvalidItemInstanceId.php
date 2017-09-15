<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class InvalidItemInstanceId extends \Exception
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid item instance id.', $value));
	}
}