<?php

namespace AdamDBurton\Destiny2ApiClient;

use AdamDBurton\Destiny2ApiClient\Module\Manifest;

class Definition
{
    protected $attributes = [];

    /**
     * Definition constructor.
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->attributes[$key];
    }

    /**
     * @param $hash
     * @param null $type
     * @return mixed|null
     */
    public function find($hash, $type = null)
    {
        $definitions = $this->findMany([$hash], $type);

        return $definitions[0] ?? null;
    }

    /**
     * @param $hashes
     * @param null $type
     */
    public function findMany($hashes, $type = null)
    {
        if (!$type) {
            $type = get_class($this);
        }

        foreach ($hashes as $i => $hash) {
            $hashes[$i] = Api::convertHash($hash);
        }

        $table = 'Destiny' . $type . 'Definition';

        $manifest = new Manifest(new Api);
    }
}