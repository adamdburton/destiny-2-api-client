<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Validation;

class InvalidItemActivityId extends ValidationException
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid activity id.', $value));
	}
}