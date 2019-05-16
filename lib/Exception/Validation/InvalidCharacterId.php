<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Validation;

class InvalidCharacterId extends ValidationException
{
    public function __construct($value)
    {
        parent::__construct(sprintf('%s is an invalid Destiny character id.', $value));
    }
}