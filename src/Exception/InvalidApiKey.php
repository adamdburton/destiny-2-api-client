<?php

namespace AdamDBurton\Destiny2ApiClient\Exception;

class InvalidApiKey extends \Exception
{
	public function __construct($apiKey)
	{
		parent::__construct(sprintf('%s is an invalid api key.', $apiKey));
	}
}