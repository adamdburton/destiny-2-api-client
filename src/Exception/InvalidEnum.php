<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class InvalidEnum extends Destiny2ApiException
{
	public function __construct($value, $enumClass)
	{
		$class = substr(strrchr($enumClass, "\\"), 1);

		parent::__construct(sprintf('%s is not a valid %s enum.', $value, $class));
	}
}