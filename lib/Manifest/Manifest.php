<?php

namespace AdamDBurton\Destiny2ApiClient\Manifest;

use AdamDBurton\Destiny2ApiClient\Exception\Manifest\DefinitionNotFound;
use AdamDBurton\Destiny2ApiClient\Manifest\Drivers\Filesystem;
use AdamDBurton\Destiny2ApiClient\Manifest\Drivers\Sqlite;
use ZipArchive;

/**
 * @package AdamDBurton\Destiny2ApiClient\Manifest
 */
class Manifest
{
    protected $driver;

    /**
     * @param Driver $driver
     */
    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param $url
     * @return Manifest
     */
    public static function fromUrl($url)
    {
        return new static(new Sqlite(self::downloadManifest($url)));
    }

    /**
     * @param $directory
     * @return Manifest
     */
    public static function fromDirectory($directory)
    {
        return new static(new Filesystem($directory));
    }

    /**
     * @param $url
     * @return string
     */
    protected static function downloadManifest($url)
    {
        $manifestName = basename($url);

        $zip = file_get_contents('https://bungie.net' . $url);
        $temp = tempnam(sys_get_temp_dir(), 'D2');

        file_put_contents($temp, $zip);

        $zip = new ZipArchive;

        if ($zip->open($temp) === TRUE) {
            file_put_contents($temp, $zip->getFromName($manifestName));
        }

        return $temp;
    }

    /**
     * @param string $type
     * @param string $hash
     * @return Definition
     * @throws DefinitionNotFound
     */
    public function getDefinition(string $type, string $hash)
    {
        $rawDefinition = $this->driver->getDefinition($type, $hash);

        if(!$rawDefinition) {
            throw new DefinitionNotFound($type, $hash);
        }

        return $this->mapRawDefinition($rawDefinition, 'AdamDBurton\Destiny2ApiClient\Manifest\Definitions\\' . $type);
    }

    /**
     * @param string $type
     * @param string[] $hashes
     * @return Definition[]
     * @throws DefinitionNotFound
     */
    public function getDefinitions(string $type, array $hashes)
    {
        $rawDefinitions = $this->driver->getDefinitions($type, $hashes);

        $this->assertAllHashesAreDefined($hashes, $rawDefinitions, $type);

        return $this->mapRawDefinitions($rawDefinitions, 'AdamDBurton\Destiny2ApiClient\Manifest\Definitions\\' . $type);
    }

    /**
     * @param array $rawDefinition
     * @param string $class
     * @return mixed
     */
    protected function mapRawDefinition(array $rawDefinition, string $class)
    {
        return new $class($rawDefinition);
    }

    /**
     * @param array $definitions
     * @param string $class
     * @return array
     */
    protected function mapRawDefinitions(array $definitions, string $class)
    {
        return array_map(function($definition) use ($class) {
            return new $class($definition);
        }, $definitions);
    }

    /**
     * @param string $path
     * @return bool
     */
    public function exportToFile(string $path): bool
    {
        return $this->driver->exportToFile($path);
    }

    /**
     * @param string $path
     * @return bool
     */
    public function exportToDirectory(string $path): bool
    {
        return $this->driver->exportToDirectory($path);
    }

    /**
     * @param array $hashes
     * @param array $rawDefinitions
     * @param string $type
     * @throws DefinitionNotFound
     */
    protected function assertAllHashesAreDefined(array $hashes, array $rawDefinitions, string $type)
    {
        foreach($hashes as $hash) {
            if(!isset($rawDefinitions[$hash])) {
                throw new DefinitionNotFound($type, $hash);
            }
        }
    }
}