<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class InvalidForumTopicCategoryFilter extends Destiny2ApiException
{
	public function __construct($value)
	{
		parent::__construct(sprintf('%s is an invalid forum topic category filter.', $value));
	}
}