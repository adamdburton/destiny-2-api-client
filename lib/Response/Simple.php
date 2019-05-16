<?php

namespace AdamDBurton\Destiny2ApiClient\Response;

use AdamDBurton\Destiny2ApiClient\Response;

/**
 * Class Simple
 * @package AdamDBurton\Destiny2ApiClient\Response
 */
class Simple extends Response
{
    /**
     * @param array $json
     * @return array
     */
    public function transform(array $json)
    {
        return $json;
    }
}