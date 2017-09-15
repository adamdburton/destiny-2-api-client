<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class InvalidItemHash extends \Exception
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid item hash.', $value));
	}
}