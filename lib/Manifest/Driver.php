<?php

namespace AdamDBurton\Destiny2ApiClient\Manifest;

use AdamDBurton\Destiny2ApiClient\Collection;
use AdamDBurton\Destiny2ApiClient\Contract\Driver as DriverContract;

/**
 * @package AdamDBurton\Destiny2ApiClient\Manifest
 */
abstract class Driver implements DriverContract
{
    /** @var array */
    protected $data = [];

    /**
     * @param string $type
     * @param string $hash
     * @return array
     */
    public function getDefinition(string $type, string $hash): array
    {
        return $this->data[$type][$hash] ?? null;
    }

    /**
     * @param string $type
     * @param string[] $hashes
     * @return array[]
     */
    public function getDefinitions(string $type, array $hashes): array
    {
        return isset($this->data[$type]) ? Collection::make($this->data[$type])->only($hashes)->all() : null;
    }
}