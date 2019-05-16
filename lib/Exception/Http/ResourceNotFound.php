<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Http;

use Throwable;

/**
 * Class ResourceNotFound
 * @package AdamDBurton\Destiny2ApiClient\Exception\Http
 */
class ResourceNotFound extends HttpException
{
    /**
     * @param $method
     * @param $endpoint
     * @param Throwable $previous
     */
    public function __construct($method, $endpoint, Throwable $previous)
    {
        parent::__construct(sprintf('%s request to %s resulted in a not found error.', $method, $endpoint), $previous->getCode(), $previous);
    }
}