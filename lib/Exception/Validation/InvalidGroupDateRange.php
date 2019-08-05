<?php

namespace AdamDBurton\Destiny2ApiClient\Exception\Validation;

/**
 * @package AdamDBurton\Destiny2ApiClient\Exception\Validation
 */
class InvalidGroupDateRange extends ValidationException
{
    /**
     * @param $value
     */
    public function __construct($value)
    {
        parent::__construct(sprintf('%s is an invalid group date range.', $value));
    }
}