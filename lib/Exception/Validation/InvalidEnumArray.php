<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Validation;

/**
 * @package AdamDBurton\Destiny2ApiClient\Exception\Validation
 */
class InvalidEnumArray extends ValidationException
{
    /**
     * @param $value
     * @param $enumClass
     */
    public function __construct($value, $enumClass)
    {
        parent::__construct(sprintf('%s is not an array of valid %s enums.', $value, $enumClass));
    }
}