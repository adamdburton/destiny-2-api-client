<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class InvalidAttribute extends Destiny2ApiException
{
	public function __construct($structName, $value)
	{
		parent::__construct(sprintf('%s is an invalid %s structure attribute.', $value, $structName));
	}
}