<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class InvalidForumPostSort extends Destiny2ApiException
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid forum post sorting.', $value));
	}
}