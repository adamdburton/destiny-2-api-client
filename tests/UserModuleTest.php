<?php

use AdamDBurton\Destiny2ApiClient\Api;
use AdamDBurton\Destiny2ApiClient\Api\Module\User;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

function api($responses = [], $apiKey = 'abcdefghijklmnopqrstuvqxyz123456', $apiRoot = null)
{
	return new Api($apiKey, new Client([
		'handler' => HandlerStack::create(new MockHandler($responses)),
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

	/**
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ApiUnavailable
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\BadRequest
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\InvalidMembershipId
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\ResourceNotFound
	 * @throws \AdamDBurton\Destiny2ApiClient\Exception\Unauthorized
	 */
	public function testGetBungieNetUserById()
	{
		$expected = (object) [ 'this is' => 'a test' ];
		$actual = api([ new Response(200, [ 'test' => '123' ], json_encode([ 'this is' => 'a test' ])) ])->user()->getBungieNetUserById(self::$membershipId);

		$this->assertEquals($expected, $actual->getResponse());
	}
}
