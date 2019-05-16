<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Validation;

class InvalidActivityType extends ValidationException
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid activity type.', $value));
	}
}