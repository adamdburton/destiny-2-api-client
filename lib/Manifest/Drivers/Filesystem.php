<?php

namespace AdamDBurton\Destiny2ApiClient\Manifest\Drivers;

use AdamDBurton\Destiny2ApiClient\Exception\Manifest\DefinitionNotFound;
use AdamDBurton\Destiny2ApiClient\Manifest\Driver;
use stdClass;

class Filesystem extends Driver
{
    /** @var string */
    protected $path;

    public function __construct($path)
    {
        $this->path = rtrim($path, '/');
    }

    /**
     * @param string $type
     * @param int $hash
     * @return stdClass
     * @throws DefinitionNotFound
     */
    public function getDefinition($type, $hash)
    {
        $data = json_decode(file_get_contents(sprintf('%s/Destiny%sDefinition.json', $this->path, $type)), true);

        if (!isset($data[$hash])) {
            throw new DefinitionNotFound($type, $hash);
        }

        return json_decode($data[$hash], true);
    }

    /**
     * @param string $type
     * @param int[] $hashes
     * @return stdClass[]
     * @throws DefinitionNotFound
     */
    public function getDefinitions(string $type, array $hashes)
    {
        $data = json_decode(file_get_contents(sprintf('%s/Destiny%sDefinition.json', $this->path, $type)), true);

        $definitions = [];

        foreach ($hashes as $hash) {
            if (!isset($data[$hash])) {
                throw new DefinitionNotFound($type, $hash);
            }

            $definitions[$hash] = json_decode($data[$hash], true);
        }

        return $definitions;
    }

    /**
     * @param string $path
     * @return mixed
     * @throws \Exception
     */
    public function export(string $path)
    {
        throw new \Exception('Cannot export with Filesystem driver.');
    }
}