<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Validation;

/**
 * @package AdamDBurton\Destiny2ApiClient\Exception\Validation
 */
class InvalidAttribute extends ValidationException
{
    /**
     * @param $name
     * @param $value
     */
    public function __construct($name, $value)
    {
        parent::__construct(sprintf('%s is an invalid %s structure attribute.', $value, $name));
    }
}