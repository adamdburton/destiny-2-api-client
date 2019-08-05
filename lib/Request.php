<?php

namespace AdamDBurton\Destiny2ApiClient;

use AdamDBurton\Destiny2ApiClient\Contract\Request as RequestContract;
use AdamDBurton\Destiny2ApiClient\Exception\Http\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\Http\BadRequest;
use AdamDBurton\Destiny2ApiClient\Exception\Http\HttpException;
use AdamDBurton\Destiny2ApiClient\Exception\Http\ResourceNotFound;
use AdamDBurton\Destiny2ApiClient\Exception\Http\Unauthorized;

/**
 * @package AdamDBurton\Destiny2ApiClient
 */
class Request implements RequestContract
{
    /** @var Api */
    protected $api;

    /** @var string */
    protected $response;

    /** @var string */
    protected $endpoint;

    /** @var array */
    protected $params = [];

    /** @var array */
    protected $body = [];

    /** @var array */
    protected $headers = [];

    /** @var array */
    protected $options = [];

    /**
     * @param Api $api
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     * @param string $response
     * @return Request
     */
    public function withResponse(string $response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @param string $endpoint
     * @param array $params
     * @return $this
     */
    public function withEndpoint(string $endpoint, array $params = [])
    {
        $this->endpoint = $endpoint;
        $this->params = $params;

        return $this;
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function withHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function withParams(array $params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @param array $body
     * @return $this
     */
    public function withBody(array $body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @param RequestParam $requestParam
     * @return $this
     */
    public function withRequestParam(RequestParam $requestParam)
    {
        $this->body = $requestParam->toArray();

        return $this;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function withOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function get(): Response
    {
        return $this->api
            ->getClient()
            ->request('GET', $this->endpoint, [
                'query' => $this->params,
                'headers' => array_merge($this->headers, $this->mergeHeaders())
            ]);
    }

    /**
     * @param array $data
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function postAsForm(array $data = []): Response
    {
        return $this->api
            ->getClient()
            ->request('POST', $this->endpoint, [
                'query' => $this->params,
                'form_params' => $data ?: $this->body,
                'headers' => array_merge($this->headers, $this->mergeHeaders([
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ]))
            ]);
    }

    /**
     * @param array $data
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function postAsJson(array $data = null): Response
    {
        return $this->api
            ->getClient()
            ->request('POST', $this->endpoint, [
                'query' => $this->params,
                'body' => json_encode($data ?: $this->body),
                'headers' => array_merge($this->headers, $this->mergeHeaders([
                    'Content-Type' => 'application/json'
                ]))
            ]);
    }

    /**
     * @param array $headers
     * @return array
     */
    protected function mergeHeaders(array $headers = [])
    {
        return $this->api->getClient()->mergeHeaders($headers);
    }

}