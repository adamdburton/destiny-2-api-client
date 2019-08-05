<?php

namespace AdamDBurton\Destiny2ApiClient\Manifest;

use AdamDBurton\Destiny2ApiClient\Exception\Manifest\DefinitionNotFound;
use AdamDBurton\Destiny2ApiClient\Manifest\Drivers\Filesystem;
use AdamDBurton\Destiny2ApiClient\Manifest\Drivers\Sqlite;

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
     * @param $driver
     * @param string $path
     * @return Manifest
     */
    public static function make($driver, string $path): Manifest
    {
        return new static(new $driver($path));
    }

    /**
     * @param string $path
     * @return Manifest
     */
    public static function fromFile(string $path)
    {
        $driver = new Sqlite();
        $driver->load($path);

        return new static($driver);
    }

    /**
     * @param string $path
     * @return Manifest
     */
    public static function fromDirectory(string $path)
    {
        $driver = new Filesystem();
        $driver->load($path);

        return new static($driver);
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
    public function export(string $path): bool
    {
        return $this->driver->export($path);
    }

    /**
     * @param array $hashes
     * @param array $rawDefinitions
     * @param string $type
     * @return void
     * @throws DefinitionNotFound
     */
    protected function assertAllHashesAreDefined($hashes, array $rawDefinitions, string $type): void
    {
        foreach($hashes as $hash) {
            if(!isset($rawDefinitions[$hash]) || !$rawDefinitions[$hash]) {
                throw new DefinitionNotFound($type, $hash);
            }
        }
    }
}