<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Http;

use Throwable;

class Unauthorized extends HttpException
{
    /**
     * @param $method
     * @param $endpoint
     * @param Throwable $previous
     */
    public function __construct($method, $endpoint, Throwable $previous)
    {
        parent::__construct(sprintf('%s request to %s resulted in an authorization error.', $method, $endpoint), $previous->getCode(), $previous);
    }
}