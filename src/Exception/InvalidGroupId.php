<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class InvalidGroupId extends \Exception
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid group id.', $value));
	}
}