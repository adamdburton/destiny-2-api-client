<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Validation;

class InvalidForumPostSort extends ValidationException
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid forum post sorting.', $value));
	}
}