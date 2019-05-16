<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Validation;

class InvalidVendorHash extends ValidationException
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid vendor hash.', $value));
	}
}