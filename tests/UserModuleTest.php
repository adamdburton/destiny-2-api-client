<?php

use AdamDBurton\Destiny2ApiClient\Api;
use AdamDBurton\Destiny2ApiClient\Api\Module\User;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

function api($responses = [], $apiKey = 'abcdefghijklmnopqrstuvqxyz123456', $apiRoot = null)
{
	return new Api($apiKey, new GuzzleClient([
		'handler' => HandlerStack::create(new MockHandler([ $responses ]))
	]), $apiRoot);
}

final class UserModuleTest extends TestCase
{
	private static $membershipId = 4611686018444497508;
	private static $characterId = 2305843009261176926;

	public function testApiUserMethodReturnsUserModuleClass()
	{
		$this->assertInstanceOf(User::class, api()->user());
	}

	public function testGetBungieNetUserById()
	{
		$expected = [];
		$actual = api([ new Response(200, [], json_encode([ 'this is' => 'a test' ])) ])->user()->getBungieNetUserById(self::$membershipId);

		var_dump($actual->getResponse());

		$this->assertEquals($expected, $actual->getResponse());
	}
}
