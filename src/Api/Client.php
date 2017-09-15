<?php

namespace AdamDBurton\Destiny2ApiClient\Api;

use Http\Client\Common\HttpMethodsClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;

class Client
{
	private $client;
	private $apiRoot = 'https://bungie.net/Platform';

	protected $apiKey;
	protected $accessToken;

	public function __construct($apiKey = null)
	{
		if($apiKey === null)
		{
			throw new \Exception('Api key is required to use Destiny 2 API');
		}

		$this->apiKey = $apiKey;

		$this->client = new HttpMethodsClient(
			HttpClientDiscovery::find(),
			MessageFactoryDiscovery::find()
		);
	}

	public function withAccessToken($token)
	{
		$this->accessToken = $token;

		return $this;
	}

	public function withoutAccessToken()
	{
		$this->accessToken = null;

		return $this;
	}

	public function get($endpoint)
	{
		return $this->processReturn(
			$this->client->get($this->endpoint($endpoint), $this->headers())
		);
	}

	public function post($endpoint, $data = null)
	{
		return $this->processReturn(
			$this->client->post($this->endpoint($endpoint), $this->headers(), $data)
		);
	}

	public function put($endpoint, $data = null)
	{
		return $this->processReturn(
			$this->client->put( $this->endpoint($endpoint), $this->headers(), $data)
		);
	}

	private function processReturn($return)
	{

	}

	private function endpoint($endpoint, $params = [])
	{
		return $this->apiRoot . '/' . ltrim($endpoint, '/');
	}

	private function headers()
	{
		return array_filter([
			'X-API-KEY' => $this->apiKey,
			'Authorization' => $this->accessToken ? ('Bearer ' . $this->accessToken) : null
		]);
	}
}