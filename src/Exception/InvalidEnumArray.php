<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class InvalidEnumArray extends Destiny2ApiException
{
	public function __construct($value, $enumClass)
	{
		parent::__construct(sprintf('%s is not an array of valid %s enums.', $value, $enumClass));
	}
}