<?php

namespace AdamDBurton\Destiny2ApiClient;

use AdamDBurton\Destiny2ApiClient\Api\Client;
use AdamDBurton\Destiny2ApiClient\Api\Module\Destiny2;
use AdamDBurton\Destiny2ApiClient\Api\Module\User;
use AdamDBurton\Destiny2ApiClient\Exception\ModuleNotImplemented;

class Api
{
	private $apiClient;

	public function __construct($apiKey, $client = null, $apiRoot = null)
	{
		$this->apiClient = new Client($apiKey, $client = null, $apiRoot = null);
	}

	/**
	 * @return User
	 */
	public function user()
	{
		return new User($this->apiClient);
	}

	public function destiny2()
	{
		return new Destiny2($this->apiClient);
	}

	public function forum()
	{
		throw new ModuleNotImplemented(__METHOD__);
	}

	public function groupV2()
	{
		throw new ModuleNotImplemented(__METHOD__);
	}

	public function communityContent()
	{
		throw new ModuleNotImplemented(__METHOD__);
	}

	public function trending()
	{
		throw new ModuleNotImplemented(__METHOD__);
	}
}