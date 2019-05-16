<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Api;

/**
 * @package AdamDBurton\Destiny2ApiClient\Exception\Api
 */
class InvalidMiddleware extends ApiException
{
    /**
     * @param $mixed
     */
    public function __construct($mixed)
	{
		parent::__construct(sprintf('The passed %s is not a valid middleware.', gettype($mixed)));
	}
}