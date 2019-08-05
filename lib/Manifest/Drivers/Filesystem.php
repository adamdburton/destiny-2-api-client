<?php

namespace AdamDBurton\Destiny2ApiClient\Manifest\Drivers;

use AdamDBurton\Destiny2ApiClient\Exception\Manifest\DefinitionNotFound;
use AdamDBurton\Destiny2ApiClient\Manifest\Driver;
use Exception;
use stdClass;

/**
 * @package AdamDBurton\Destiny2ApiClient\Manifest\Drivers
 */
class Filesystem extends Driver
{
    /** @var string */
    protected $path;

    /**
     * @param string $path
     * @return bool
     */
    public function load(string $path): bool
    {
        $this->path = rtrim($path, '/');

        return is_dir($this->path);
    }

    /**
     * @param string $type
     * @param int $hash
     * @return array
     */
    public function getDefinition($type, $hash): array
    {
        $data = json_decode(file_get_contents(sprintf('%s/Destiny%sDefinition.json', $this->path, $type)), true);

        return isset($data[$hash]) ? json_decode($data[$hash], true) : null;
    }

    /**
     * @param string $type
     * @param int[] $hashes
     * @return array[]
     */
    public function getDefinitions(string $type, array $hashes): array
    {
        $data = json_decode(file_get_contents(sprintf('%s/Destiny%sDefinition.json', $this->path, $type)), true);

        $definitions = [];

        foreach ($hashes as $hash) {
            if(file_exists($data[$hash])) {
                $definitions[$hash] = json_decode($data[$hash], true);
            } else {
                $definitions[$hash] = null;
            }
        }

        return $definitions;
    }

    /**
     * @param string $path
     * @return bool
     */
    public function export(string $path): bool
    {
        throw new ('The Filesystem driver does not support being exported.');
    }
}