<?php

namespace AdamDBurton\Destiny2ApiClient;

use AdamDBurton\Destiny2ApiClient\Contract\Response as ResponseContract;
use Psr\Http\Message\ResponseInterface;


/**
 * @package AdamDBurton\Destiny2ApiClient
 */
abstract class Response implements ResponseContract
{
    /** @var ResponseInterface */
    protected $response;

    /** @var Api */
    protected $api;

    /**
     * Response constructor.
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @param Api $api
     * @return $this
     */
    public function withApi(Api $api)
    {
        $this->api = $api;

        return $this;
    }

    /**
     * @return bool
     */
    public function successful()
    {
        return substr($this->response()->getStatusCode(), 0, 1) == '2';
    }

    /**
     * @return ResponseInterface
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * @return int
     */
    public function statusCode()
    {
        return $this->response->getStatusCode();
    }

    /**
     * @return string[][]
     */
    public function headers()
    {
        return $this->response->getHeaders();
    }

    /**
     * @param bool $transform
     * @param bool $mapDefinitions
     * @return array
     */
    public function json($transform = true, $mapDefinitions = true)
    {
        $json = json_decode((string)$this->response->getBody(), true);

        if (isset($json['Response'])) {
            $json = $json['Response'];
        }

        if ($transform) {
            $json = $this->transform($json);
        }

        if ($mapDefinitions) {
            $json = $this->mapDefinitions($json);
        }

        return $json;
    }
}