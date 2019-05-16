<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class ApiKeyRequired extends Destiny2ApiException
{
	public function __construct()
	{
		parent::__construct('An API key is required.');
	}
}