<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Validation;

/**
 * @package AdamDBurton\Destiny2ApiClient\Exception\Validation
 */
class InvalidEnum extends ValidationException
{
    /**
     * @param $value
     * @param $enumClass
     */
    public function __construct($value, $enumClass)
    {
        $class = substr(strrchr($enumClass, "\\"), 1);

        parent::__construct(sprintf('%s is not an valid %s enum.', $value, $class));
    }
}