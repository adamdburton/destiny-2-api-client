<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class InvalidItemInstanceId extends Destiny2ApiException
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid item instance id.', $value));
	}
}