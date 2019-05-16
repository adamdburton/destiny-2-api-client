<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Validation;

class InvalidComponentType extends ValidationException
{
    public function __construct($value)
    {
        parent::__construct(sprintf('%s is an invalid component type.', $value));
    }
}