<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Validation;

class InvalidGroupId extends ValidationException
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid group id.', $value));
	}
}