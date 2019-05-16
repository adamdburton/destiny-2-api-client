<?php

namespace AdamDBurton\Destiny2ApiClient;

use AdamDBurton\Destiny2ApiClient\Exception\ApiKeyRequired;
use AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\BadRequest;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidApiKey;
use AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound;
use AdamDBurton\Destiny2ApiClient\Exception\Unauthorized;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Message\ResponseInterface;

class Client
{
    const API_ROOT = 'https://www.bungie.net/en/OAuth/Authorize';

    /** @var GuzzleClient */
    protected $client;

    /** @var array */
    protected $config = [];

    /** @var string */
    protected $accessToken;

    /**
     * Client constructor.
     * @param null $apiKey
     * @param null $client
     * @param string $apiRoot
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function withConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    public function getConfig($item, $default = null)
    {
        return $this->config[$item] ?? $default;
    }

    /**
     * @param $token
     * @return $this
     */
    public function withAccessToken($token)
    {
        $this->accessToken = $token;

        return $this;
    }

    /**
     * @return $this
     */
    public function withoutAccessToken()
    {
        $this->accessToken = null;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasAccessToken()
    {
        return $this->accessToken !== null;
    }

    /**
     * @param $endpoint
     * @param array $params
     * @param array $headers
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
     */
    public function get($endpoint, $params = [], $headers = [])
    {
        return $this->request('GET', $endpoint, [
            'query' => $params,
            'headers' => array_merge($headers, $this->headers())
        ]);
    }

    /**
     * @param $endpoint
     * @param array $data
     * @param array $headers
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
     */
    public function postAsForm($endpoint, $data = [], $headers = [])
    {
        return $this->request('POST', $endpoint, [
            'form_params' => $data,
            'headers' => array_merge($headers, $this->headers([
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]))
        ]);
    }

    /**
     * @param $endpoint
     * @param $data
     * @param array $headers
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws ResourceNotFound
     * @throws Unauthorized
     * @throws ApiKeyRequired
     */
    public function postAsJson($endpoint, $data, $headers = [])
    {
        return $this->request('POST', $endpoint, [
            'body' => json_encode($data),
            'headers' => array_merge($headers, $this->headers([
                'Content-Type' => 'application/json'
            ]))
        ]);
    }

    /**
     * @param $method
     * @param $endpoint
     * @param array $options
     * @return Response
     * @throws ApiUnavailable
     * @throws ResourceNotFound
     * @throws BadRequest
     * @throws Unauthorized
     * @throws ApiKeyRequired
     */
    private function request($method, $endpoint, $options = [])
    {
        if(!$this->apiKey) {
            throw new ApiKeyRequired;
        }

        try {
            return $this->processResponse(
                $this->client->request($method, $this->endpoint($endpoint), $options)
            );
        } catch (ClientException $e) {
            if ($e->getCode() == 404) {
                throw new ResourceNotFound(sprintf('%s request to %s was not found.', $method, $this->endpoint($endpoint)), $e->getCode(), $e);
            } elseif ($e->getCode() == 401) {
                throw new Unauthorized(sprintf('%s request to %s resulted in an authorization error.', $method, $this->endpoint($endpoint)), $e->getCode(), $e);
            } elseif ($e->getCode() == 400) {
                $response = json_decode((string)$e->getResponse()->getBody());

                throw new BadRequest(sprintf('Request error (%s): %s', $response->error, $response->error_description), $e->getCode(), $e);
            } else {
                throw $e;
            }
        } catch (ServerException $e) {
            throw new ApiUnavailable(sprintf('%s request to %s resulted in a server error.', $method, $this->endpoint($endpoint)), $e->getCode(), $e);
        } catch (RequestException $e) {
            throw new ApiUnavailable(sprintf('%s request to %s resulted in a request error.', $method, $this->endpoint($endpoint)), $e->getCode(), $e);
        } catch (GuzzleException $e) {
            throw new ApiUnavailable(sprintf('%s request to %s resulted in an error.', $method, $this->endpoint($endpoint)), $e->getCode(), $e);
        } finally {
            // Reset access token after each request

            $this->accessToken = null;
        }
    }

    /**
     * @param ResponseInterface $response
     * @return Response
     */
    private function processResponse(ResponseInterface $response)
    {
        return new Response($response);
    }

    /**
     * @param $endpoint
     * @return string
     */
    private function endpoint($endpoint)
    {
        return $this->apiRoot . '/' . trim($endpoint, '/') . '/';
    }

    /**
     * @param array $mergeHeaders
     * @return array
     */
    private function headers($mergeHeaders = [])
    {
        return array_filter(array_merge([
            'X-API-KEY' => $this->getConfig('api_key'),
            'Authorization' => $this->accessToken ? ('Bearer ' . $this->accessToken) : null,
            'Accept' => 'application/json'
        ], $mergeHeaders));
    }

    /**
     * @param $apiKey
     * @throws InvalidApiKey
     */
    private function assertIsValidApiKey($apiKey)
    {
        if (strlen($apiKey) != 32) {
            throw new InvalidApiKey($apiKey);
        }
    }
}