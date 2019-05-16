<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Api;

/**
 * @package AdamDBurton\Destiny2ApiClient\Exception\Api
 */
class AccessTokenRequired extends ApiException
{
    public function __construct()
	{
		parent::__construct('An access token is required.');
	}
}