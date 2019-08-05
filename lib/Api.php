<?php

namespace AdamDBurton\Destiny2ApiClient;

use AdamDBurton\Destiny2ApiClient\Exception\Api\ApiKeyRequired;
use AdamDBurton\Destiny2ApiClient\Manifest\Cache;
use AdamDBurton\Destiny2ApiClient\Manifest\Manifest;
use AdamDBurton\Destiny2ApiClient\Module\Destiny2;
use GuzzleHttp\ClientInterface;

/**
 * @package AdamDBurton\Destiny2ApiClient
 */
class Api
{
    /** @var Client */
    protected $client;

    /** @var array */
    protected $config;

    /** @var Manifest */
    protected $manifest;

    /** @var Middleware */
    protected $middleware;

    /** @var Cache */
    protected $cache;

    /**
     * @param array|null $config
     * @param ClientInterface $httpClient
     */
    public function __construct(array $config = null, ClientInterface $httpClient = null)
    {
        $this->client = new Client($this, $httpClient ?: new \GuzzleHttp\Client);

        $this->middleware = new Middleware;
        $this->cache = new Cache();

        if (!is_null($config)) {
            $this->withConfig($config);
        }
    }

    /**
     * @param $class
     * @return Module
     */
    public function module($class): Module
    {
        return new $class($this);
    }

    /**
     * @return Request
     */
    public function request(): Request
    {
        return new Request($this);
    }

    /**
     * @param $config
     * @return $this
     * @throws ApiKeyRequired
     */
    public function withConfig($config): Api
    {
        $this->config = $config;

        $this->validateApiKey();

        $this->initManifestCache();
        $this->initMiddleware();

        return $this;
    }

    /**
     * @param $key
     * @param mixed $default
     * @return mixed|null
     */
    public function getConfig($key, $default = null)
    {
        return Collection::make($this->config)->get($key, $default);
    }

    /**
     * @param Manifest $manifest
     * @return $this
     */
    public function withManifest(Manifest $manifest): Api
    {
        $this->manifest = $manifest;

        return $this;
    }

    /**
     * @return $this
     */
    public function withoutManifest(): Api
    {
        $this->manifest = null;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasManifest(): bool
    {
        return $this->manifest !== null;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @return Middleware
     */
    public function getMiddleware(): Middleware
    {
        return $this->middleware;
    }

    /**
     * @throws ApiKeyRequired
     */
    protected function validateApiKey()
    {
        if (!$this->getConfig('api_key')) {
            throw new ApiKeyRequired;
        }
    }

    protected function initManifestCache()
    {

    }
}