<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Api;

/**
 * @package AdamDBurton\Destiny2ApiClient\Exception\Api
 */
class ApiKeyRequired extends ApiException
{
	public function __construct()
	{
		parent::__construct('An API key is required.');
	}
}