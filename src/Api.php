<?php

namespace AdamDBurton\Destiny2ApiClient;

use AdamDBurton\Destiny2ApiClient\Api\Client;
use AdamDBurton\Destiny2ApiClient\Api\Module\App;
use AdamDBurton\Destiny2ApiClient\Api\Module\Destiny2;
use AdamDBurton\Destiny2ApiClient\Api\Module\User;
use AdamDBurton\Destiny2ApiClient\Exception\ModuleNotImplemented;

/**
 * Class Api
 * @package AdamDBurton\Destiny2ApiClient
 * @method App app()
 * @method Destiny2 destiny2()
 * @method User user()
 */
class Api
{
	private $apiClient;
	private $modules = [];

	/**
	 * Api constructor.
	 * @param $apiKey
	 * @param null $client
	 * @param null $apiRoot
	 */
	public function __construct($apiKey, $client = null, $apiRoot = null)
	{
		$this->apiClient = new Client($apiKey, $client = null, $apiRoot = null);
	}

	/**
	 * @param $name
	 * @param $arguments
	 * @return App|Destiny2|User
	 * @throws ModuleNotImplemented
	 */
	public function __call($name, $arguments)
	{
		return $this->__get($name);
	}

	/**
	 * @param $name
	 * @return App|Destiny2|User
	 * @throws ModuleNotImplemented
	 */
	public function __get($name)
	{
		$class = __NAMESPACE__ . '\\' . ucfirst($name);

		if(!isset($this->modules[$name]))
		{
			if(class_exists($class))
			{
				$this->modules[$name] = new $class($this->apiClient);
			}
			else
			{
				throw new ModuleNotImplemented($name);
			}
		}

		return $this->modules[$name];
	}
}