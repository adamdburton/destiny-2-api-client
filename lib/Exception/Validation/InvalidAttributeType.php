<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Validation;

/**
 * @package AdamDBurton\Destiny2ApiClient\Exception\Validation
 */
class InvalidAttributeType extends ValidationException
{
    /**
     * @param $attribute
     * @param $type
     */
    public function __construct($attribute, $type)
    {
        parent::__construct(sprintf('%s attribute must be a %s.', $attribute, $type));
    }
}