<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class InvalidCharacterId extends \Exception
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid Destiny character id.', $value));
	}
}