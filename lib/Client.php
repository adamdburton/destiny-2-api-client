<?php

namespace AdamDBurton\Destiny2ApiClient;

use AdamDBurton\Destiny2ApiClient\Exception\Api\InvalidApiKey;
use AdamDBurton\Destiny2ApiClient\Exception\Http\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\Http\BadRequest;
use AdamDBurton\Destiny2ApiClient\Exception\Http\HttpException;
use AdamDBurton\Destiny2ApiClient\Exception\Http\ResourceNotFound;
use AdamDBurton\Destiny2ApiClient\Exception\Http\Unauthorized;
use AdamDBurton\Destiny2ApiClient\Response\Simple;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Message\ResponseInterface;

/**
 * @package AdamDBurton\Destiny2ApiClient
 */
class Client
{
    protected const API_ROOT = 'https://www.bungie.net/Platform';

    /** @var Api */
    protected $api;

    /** @var ClientInterface */
    protected $client;

    /** @var array */
    protected $config = [];

    /** @var string */
    protected $accessToken;

    /** @var string */
    protected $responseClass;

    /** @var bool */
    protected $includeDefinitions = false;

    /**
     * @param Api $api
     * @param ClientInterface $client
     */
    public function __construct(Api $api, ClientInterface $client)
    {
        $this->api = $api;
        $this->client = $client;
    }

    /**
     * @param $responseClass
     * @return $this
     */
    public function withResponse($responseClass): Client
    {
        $this->responseClass = $responseClass;

        return $this;
    }

    /**
     * @return $this
     */
    public function withDefaultResponse(): Client
    {
        $this->responseClass = null;

        return $this;
    }

    /**
     * @return $this
     */
    public function withDefinitions(): Client
    {
        $this->includeDefinitions = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function withoutDefinitions(): Client
    {
        $this->includeDefinitions = false;

        return $this;
    }

    /**
     * @param $token
     * @return $this
     */
    public function withAccessToken($token): Client
    {
        $this->accessToken = $token;

        return $this;
    }

    /**
     * @return $this
     */
    public function withoutAccessToken(): Client
    {
        $this->accessToken = null;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasAccessToken(): bool
    {
        return $this->accessToken !== null;
    }

    /**
     * @param $method
     * @param $endpoint
     * @param array $options
     * @return Response
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function request($method, $endpoint, $options = []): Response
    {
        try {
            $response = $this->performRequest($method, $endpoint, $options);

            return $this->processResponse($this->processMiddleware($response));
        } catch (ClientException $exception) {
            if ($exception->getCode() == 404) {
                throw new ResourceNotFound($method, $endpoint, $exception);
            } elseif ($exception->getCode() == 401) {
                throw new Unauthorized($method, $endpoint, $exception);
            } elseif ($exception->getCode() == 400) {
                throw new BadRequest($method, $endpoint, $exception);
            } else {
                throw new HttpException($method, $endpoint, $exception);
            }
        } catch (ServerException $exception) {
            throw new ApiUnavailable('server', $method, $endpoint, $exception);
        } catch (RequestException $exception) {
            throw new ApiUnavailable('request', $method, $endpoint, $exception);
        } catch (GuzzleException $exception) {
            throw new ApiUnavailable('unknown', $method, $endpoint, $exception);
        }
    }

    /**
     * @param $method
     * @param $endpoint
     * @param $options
     * @return ResponseInterface
     * @throws GuzzleException
     */
    protected function performRequest($method, $endpoint, $options): ResponseInterface
    {
        return $this->client->request($method, $this->endpointUrl($endpoint), $this->mergeOptions($options));
    }

    /**
     * @param Response $response
     * @return Response
     */
    protected function processResponse(Response $response): Response
    {
        $response = $this->responseFactory($response, $this->responseClass)->withApi($this->api);

        $this->withDefaultResponse();

        return $response;
    }

    /**
     * @param $endpoint
     * @return string
     */
    protected function endpointUrl($endpoint): string
    {
        return sprintf('%s/%s/', static::API_ROOT, trim($endpoint, '/'));
    }

    /**
     * @param array $mergeHeaders
     * @return array
     * @throws Exception\Api\ApiKeyRequired
     */
    public function mergeHeaders($mergeHeaders = []): array
    {
        return array_filter(array_merge([
            'X-API-KEY' => $this->api->withConfig('api_key'),
            'Authorization' => $this->accessToken ? ('Bearer ' . $this->accessToken) : null,
            'Accept' => 'application/json'
        ], $mergeHeaders));
    }

    /**
     * @param $apiKey
     * @throws InvalidApiKey
     * @return void
     */
    protected function assertIsValidApiKey($apiKey): void
    {
        if (strlen($apiKey) != 32) {
            throw new InvalidApiKey($apiKey);
        }
    }

    /**
     * @param Response $response
     * @param string $class
     * @return Response
     */
    protected function responseFactory(Response $response, string $class): Response
    {
        if ($class) {
            return new $class($response);
        }

        return new Simple($response);
    }

    /**
     * @param array $options
     * @return array
     */
    protected function mergeOptions(array $options): array
    {
        if ($this->includeDefinitions) {
            if (!isset($options['query'])) {
                $options['query'] = [];
            }

            $options['query']['definitions'] = 'true';
        }

        return $options;
    }

    /**
     * @param ResponseInterface $response
     * @return Response
     */
    protected function processMiddleware(ResponseInterface $response): Response
    {
        return $this->api->getMiddleware()->handle($response, function ($response) {
            return $response;
        });
    }
}