<?php

namespace AdamDBurton\Destiny2ApiClient\Manifest;

/**
 * @package AdamDBurton\Destiny2ApiClient\Manifest
 */
abstract class Definition
{
    protected $attributes = [];

    /**
     * Definition constructor.
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        $this->attributes = (array) $attributes;
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
     * @param Manifest $manifest
     */
    public function mapDefinitions(Manifest $manifest)
    {

    }
}