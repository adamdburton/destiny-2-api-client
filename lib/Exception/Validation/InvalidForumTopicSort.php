<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Validation;

class InvalidForumTopicSort extends ValidationException
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid forum topic sorting.', $value));
	}
}