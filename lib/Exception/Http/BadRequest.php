<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Http;

use GuzzleHttp\Exception\ClientException;
use Throwable;

/**
 * @package AdamDBurton\Destiny2ApiClient\Exception\Http
 */
class BadRequest extends HttpException
{
    /**
     * @param $method
     * @param $endpoint
     * @param Throwable $previous
     */
    public function __construct($method, $endpoint, Throwable $previous)
    {
        /** @var ClientException $previous */
        $response = json_decode((string)$previous->getResponse()->getBody(), true);

        $error = $response['error'];
        $errorDescription = $response['error_description'];

        parent::__construct(sprintf('%s request to %s resulted in an error (%s): %s', $method, $endpoint, $error, $errorDescription), $previous->getCode(), $previous);
    }
}