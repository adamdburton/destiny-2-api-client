<?php

namespace AdamDBurton\Destiny2ApiClient;

use AdamDBurton\Destiny2ApiClient\Module\App;
use AdamDBurton\Destiny2ApiClient\Module\Auth;
use AdamDBurton\Destiny2ApiClient\Module\Destiny2;
use AdamDBurton\Destiny2ApiClient\Module\Forum;
use AdamDBurton\Destiny2ApiClient\Module\Manifest;
use AdamDBurton\Destiny2ApiClient\Module\User;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;

/**
 * Class Api
 * @package AdamDBurton\Destiny2ApiClient
 */
class Api
{
    /** @var Client */
	protected $client;

	/** @var array */
	protected $config;

    /**
     * Api constructor.
     * @param $apiKey
     * @param null $client
     * @param null $apiRoot
     */
	public function __construct(HttpClient $httpClient = null)
	{
        $httpClient = $httpClient ?: HttpClientDiscovery::find();

		$this->client = new Client($httpClient);
	}

    /**
     * @param $config
     * @return $this
     */
    public function withConfig($config)
    {
        $this->apiClient->withConfig($config);

        return $this;
    }

    /**
     * @return App
     */
    public function app()
    {
        return new App($this->apiClient);
    }

    /**
     * @return Auth
     */
    public function auth()
    {
        return new Auth($this->apiClient);
    }

    /**
     * @return Destiny2
     */
    public function destiny2()
    {
        return new Destiny2($this->apiClient);
    }

    /**
     * @return Manifest
     */
    public function manifest()
    {
        return new Manifest($this->apiClient);
    }

    /**
     * @return User
     */
    public function user()
    {
        return new User($this->apiClient);
    }

    /**
     * @return Forum
     */
    public function forum()
    {
        return new Forum($this->apiClient);
    }

    /**
     * @param $hash int
     * @return int
     */
    public static function convertHash($hash)
    {
        $maxInt = 2147483647;
        $minInt = -2147483648;

        if ($hash < 0) {
            return $hash;
        } elseif ($hash < $maxInt) {
            return $hash;
        }

        return ($minInt - ($maxInt - $hash)) - 1;
    }
}