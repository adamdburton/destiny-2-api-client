<?php /** @noinspection PhpUndefinedClassInspection */

namespace AdamDBurton\Destiny2ApiClient\Manifest;

use AdamDBurton\Destiny2ApiClient\Api;
use AdamDBurton\Destiny2ApiClient\Exception\Http\ApiUnavailable;
use AdamDBurton\Destiny2ApiClient\Exception\Http\BadRequest;
use AdamDBurton\Destiny2ApiClient\Exception\Http\HttpException;
use AdamDBurton\Destiny2ApiClient\Exception\Http\ResourceNotFound;
use AdamDBurton\Destiny2ApiClient\Exception\Http\Unauthorized;
use AdamDBurton\Destiny2ApiClient\Module\Destiny2;
use SplFileInfo;
use ZipArchive;

/**
 * @package AdamDBurton\Destiny2ApiClient
 */
class Cache
{
    const CACHE_FILENAME = 'destiny2.cache';

    /** @var Api */
    protected $api;

    /** @var array */
    protected $config;

    /**
     * @param Api $api
     * @param array|null $config
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    public function __construct(Api $api, array $config = null)
    {
        $this->api = $api;

        if ($config) {
            $this->withConfig($config);
        }
    }

    /**
     * @param array $config
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    protected function withConfig(array $config)
    {
        $this->config = $config;

        $this->initializeCache();
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function getConfig($key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }

    /**
     * @return string
     */
    protected function getPath(): string
    {
        return rtrim($this->getConfig('path'), '/');
    }

    /**
     * @return string
     */
    protected function getFilename(): string
    {
        return $this->getPath() . self::CACHE_FILENAME;
    }

    /**
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    protected function initializeCache()
    {
        $path = $this->getPath();

        if (!is_dir($path)) {
            mkdir($path);
        }

        if ($this->hasExpired()) {
            $this->exportManifest();
        }

        $this->api->withManifest(Manifest::fromDirectory($path));
    }

    /**
     * @return bool
     */
    protected function hasExpired(): bool
    {
        $file = $this->getFilename();
        $lifetime = $this->getConfig('lifetime', 604800);

        return !file_exists($file) || filemtime($file) < time() - $lifetime;
    }

    /**
     * @return bool
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    protected function exportManifest(): bool
    {
        $manifest = $this->getManifestForLanguage($this->getConfig('language', 'en'));

        return $manifest->export($this->getFilename());
    }

    /**
     * @param $language
     * @return Manifest
     * @throws ApiUnavailable
     * @throws BadRequest
     * @throws HttpException
     * @throws ResourceNotFound
     * @throws Unauthorized
     */
    protected function getManifestForLanguage($language): Manifest
    {
        $manifestResponse = (new Destiny2($this->api))->getDestinyManifest()->json();
        $manifestLocation = $manifestResponse['mobileWorldContentPaths'][$language];

        $manifestFile = $this->downloadManifest($manifestLocation);

        return Manifest::fromFile($manifestFile->getPath());
    }

    /**
     * @param $url
     * @return SplFileInfo
     */
    protected function downloadManifest($url): SplFileInfo
    {
        $manifestName = basename($url);

        $zip = file_get_contents('https://bungie.net' . $url);
        $temp = tempnam(sys_get_temp_dir(), 'D2');

        file_put_contents($temp, $zip);

        $zip = new ZipArchive;

        if ($zip->open($temp) === TRUE) {
            file_put_contents($temp, $zip->getFromName($manifestName));
        }

        return new SplFileInfo($temp);
    }

}