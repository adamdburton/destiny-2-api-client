<?php

namespace AdamDBurton\Destiny2ApiClient\Contract;

/**
 * @package AdamDBurton\Destiny2ApiClient\Contract
 */
interface Response
{
    /**
     * @param array $json
     * @return array
     */
    public function transform(array $json);
}