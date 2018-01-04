<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class InvalidAttributeType extends Destiny2ApiException
{
	public function __construct($attribute, $type)
	{
		parent::__construct(sprintf('%s attribute must be a %s.', $attribute, $type));
	}
}