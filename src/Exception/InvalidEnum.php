<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class InvalidEnum extends Destiny2ApiException
{
	public function __construct($value, $enumClass)
	{
		parent::__construct(sprintf('%s is not an valid %s enum.', $value, $enumClass));
	}
}