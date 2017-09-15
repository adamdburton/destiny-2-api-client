<?php

namespace AdamDBurton\Destiny2ApiClient\Api;

use AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidApiKey;
use AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Message\ResponseInterface;

class Client
{
	private $client;

	protected $apiRoot;
	protected $apiKey;
	protected $accessToken;

	/**
	 * Client constructor.
	 * @param string $apiRoot
	 * @param null $apiKey
	 * @param null $client
	 */
	public function __construct($apiKey = null, $client = null, $apiRoot = null)
	{
		$this->assertIsValidApiKey($apiKey);

		if($apiRoot === null)
		{
			$apiRoot = 'https://bungie.net/Platform';
		}

		$this->apiKey = $apiKey;
		$this->apiRoot = $apiRoot;

		if($client === null)
		{
			$client = new GuzzleClient();
		}

		$this->client = $client;
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
	 * @param null $params
	 * @return Response
	 */
	public function get($endpoint, $params = null)
	{
		return $this->request('GET', $endpoint, $params);
	}

	/**
	 * @param $endpoint
	 * @param null|array $data
	 * @return Response
	 */
	public function post($endpoint, $data = null)
	{
		return $this->request('POST', $endpoint, $data);
	}

	/**
	 * @param $apiKey
	 * @throws InvalidApiKey
	 */
	private function assertIsValidApiKey($apiKey)
	{
		if(strlen($apiKey) != 32)
		{
			throw new InvalidApiKey($apiKey);
		}
	}

	/**
	 * @param $method
	 * @param $endpoint
	 * @param array $data
	 * @return Response
	 * @throws ApiUnavailable
	 * @throws ResourceNotFound
	 */
	private function request($method, $endpoint, $data = null)
	{
		try
		{
			$options = [
				'body' => $method == 'GET' ? null : json_encode($data),
				'query' => $method == 'GET' ? $data : null,
				'headers' => $this->headers()
			];

			echo sprintf('%s request to %s', $method, $this->endpoint($endpoint));

			return $this->processResponse(
				$this->client->request($method, $this->endpoint($endpoint), array_filter($options))
			);
		}
		catch(ClientException $e)
		{
			if($e->getCode() == 404)
			{
				throw new ResourceNotFound(sprintf('%s request to resource not found at %s', $method, $this->endpoint($endpoint)), $e->getCode(), $e);
			}
		}
		catch(ServerException $e)
		{
			throw new ApiUnavailable(sprintf('%s request to resource not found at %s', $method, $this->endpoint($endpoint)), $e->getCode(), $e);
		}
		catch(RequestException $e)
		{
			throw new ApiUnavailable(sprintf('%s request to resource not found at %s', $method, $this->endpoint($endpoint)), $e->getCode(), $e);
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
		return $this->apiRoot . '/' . ltrim($endpoint, '/');
	}

	/**
	 * @return array
	 */
	private function headers()
	{
		return array_filter([
			'X-API-KEY' => $this->apiKey,
			'Authorization' => $this->accessToken ? ('Bearer ' . $this->accessToken) : null,
			'Accept' => 'application/json',
			'Content-Type' => 'application/json'
		]);
	}
}