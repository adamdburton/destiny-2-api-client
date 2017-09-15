<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class InvalidActivityType extends \Exception
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid activity type.', $value));
	}
}