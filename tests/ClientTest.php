<?php

use AdamDBurton\Destiny2ApiClient\Api\Client;
use AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidApiKey;
use AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class ClientTest extends TestCase
{
	private static $guzzleClient;

	private static $validApiKey = 'abcdefghijklmnopqrstuvqxyz123456';
	private static $invalidApiKey = 'invalid-key';

	public static function setUpBeforeClass()
	{
		$mockHandler = new MockHandler([
			new Response(500),
			new Response(404)
		]);

		self::$guzzleClient = new GuzzleClient([
			'handler' => HandlerStack::create($mockHandler)
		]);
	}

	public function testClient()
	{
		$client = new Client(self::$validApiKey, self::$guzzleClient);

		$this->assertInstanceOf(Client::class, $client);
	}

	public function testInvalidApiKey()
	{
		$this->expectException(InvalidApiKey::class);

		new Client(self::$invalidApiKey, self::$guzzleClient);
	}

	public function testBadApiBase()
	{
		$client = new Client(self::$validApiKey, self::$guzzleClient, 'https://invalid.domain/api');

		$this->expectException(ApiUnavailable::class);

		$client->get('');
	}

	public function testEmptyGetThrowsResourceNotFound()
	{
		$client = new Client(self::$validApiKey, self::$guzzleClient);

		$this->expectException(ResourceNotFound::class);

		$client->get('');
	}
}
