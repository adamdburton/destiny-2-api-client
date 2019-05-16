<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Validation;

class InvalidMembershipType extends ValidationException
{
    public function __construct($value)
    {
        parent::__construct(sprintf('%s is an invalid membership type.', $value));
    }
}