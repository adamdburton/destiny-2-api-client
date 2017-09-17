<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class AccessTokenRequired extends Destiny2ApiException
{
	public function __construct()
	{
		parent::__construct('An access token is required.');
	}
}