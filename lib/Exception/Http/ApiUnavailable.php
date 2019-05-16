<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Http;

use Throwable;

/**
 * @package AdamDBurton\Destiny2ApiClient\Exception\Http
 */
class ApiUnavailable extends HttpException
{
    /**
     * @param $reason
     * @param $method
     * @param $endpoint
     * @param Throwable $previous
     */
    public function __construct($reason, $method, $endpoint, Throwable $previous)
    {
        parent::__construct(sprintf('%s request to %s resulted in a %s error.', $method, $endpoint, $reason), $previous->getCode(), $previous);
    }
}