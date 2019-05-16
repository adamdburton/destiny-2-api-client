<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Validation;

class InvalidItemHash extends ValidationException
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid item hash.', $value));
	}
}