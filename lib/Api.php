<?php

namespace AdamDBurton\Destiny2ApiClient;

use AdamDBurton\Destiny2ApiClient\Exception\Api\ApiKeyRequired;
use AdamDBurton\Destiny2ApiClient\Manifest\Manifest;
use AdamDBurton\Destiny2ApiClient\Module\Destiny2;
use GuzzleHttp\ClientInterface;

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

    /** @var Manifest */
    protected $manifest;

    /** @var Middleware */
    protected $middleware;

    /**
     * Api constructor.
     * @param array|null $config
     * @param ClientInterface $httpClient
     */
    public function __construct(array $config = null, ClientInterface $httpClient = null)
    {
        $this->client = new Client($this, $httpClient ?: new \GuzzleHttp\Client);

        if (!is_null($config)) {
            $this->withConfig($config);
        }
    }

    /**
     * @param $class
     * @return Module
     */
    public function module($class)
    {
        return new $class($this);
    }

    /**
     * @param string|null $response
     * @return Request
     */
    public function request(string $response = null)
    {
        $request = new Request($this);

        if ($response) {
            $request->response($response);
        }

        return $request;
    }

    /**
     * @param $config
     * @return $this
     * @throws ApiKeyRequired
     */
    public function withConfig($config)
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
        return $this->config[$key] ?? $default;
    }

    /**
     * @param Manifest $manifest
     * @return $this
     */
    public function withManifest(Manifest $manifest)
    {
        $this->manifest = $manifest;

        return $this;
    }

    /**
     * @return $this
     */
    public function withoutManifest()
    {
        $this->manifest = null;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasManifest()
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
    public function getMiddleware()
    {
        return $this->middleware;
    }

    protected function validateApiKey()
    {
        if (!$this->getConfig('api_key')) {
            throw new ApiKeyRequired;
        }
    }

    protected function initManifestCache()
    {
        if (!isset($this->config['cache'])) {
            return;
        }

        ['enabled' => $enabled, 'driver' => $driver, 'lifetime' => $lifetime, 'path' => $path, 'language' => $language] = $this->config['cache'];

        if ($enabled) {
            $path = rtrim($path, '/');

            if (!is_dir($path)) {
                mkdir($path);
            }

            if ($this->hasCacheExpired($path, $lifetime)) {
                $this->cacheManifest($path, $language);
            }

            $this->withManifest(Manifest::fromDirectory($path));
        }
    }

    protected function initMiddleware()
    {
        if (!isset($this->config['middleware'])) {
            return;
        }

        $this->middleware = (new Middleware)->middleware($this->config['middleware']);
    }

    /**
     * @param $hash int
     * @return int
     */
    public static function convertHash(int $hash)
    {
        return $hash < 0 ? $hash + 4294967296 : $hash;
    }

    /**
     * @param int[] $hashes
     * @return int[]
     */
    public static function convertHashes($hashes)
    {
        return array_map(function ($hash) {
            return self::convertHash($hash);
        }, $hashes);
    }

    protected function cacheManifest()
    {
        ['driver' => $driver, 'lifetime' => $lifetime, 'path' => $path, 'language' => $language] = $this->config['cache'];

        $manifestResponse = (new Destiny2($this))->getDestinyManifest()->json();

        $manifestUrl = $manifestResponse['mobileWorldContentPaths'][$language];

        touch($path . '/destiny2.cache');

        $manifest = Manifest::fromUrl($manifestUrl);

        $manifest->export($path);
    }

    /**
     * @param string $path
     * @param int $lifetime
     * @return bool
     */
    protected function hasCacheExpired()
    {
        ['lifetime' => $lifetime, 'path' => $path, 'language' => $language] = $this->config['cache'];

        return !file_exists($path . '/destiny2.cache') || filemtime($path . '/destiny2.cache') < time() - $lifetime;
    }
}