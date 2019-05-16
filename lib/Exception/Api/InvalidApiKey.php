<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Api;

/**
 * @package AdamDBurton\Destiny2ApiClient\Exception\Api
 */
class InvalidApiKey extends ApiException
{
    /**
     * @param $apiKey
     */
    public function __construct($apiKey)
	{
		parent::__construct(sprintf('%s is not a valid API key.', $apiKey));
	}
}