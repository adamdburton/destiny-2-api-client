<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Validation;

class InvalidItemInstanceId extends ValidationException
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid item instance id.', $value));
	}
}