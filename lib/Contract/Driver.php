<?php

namespace AdamDBurton\Destiny2ApiClient\Contract;

/**
 * @package AdamDBurton\Destiny2ApiClient\Contract
 */
interface Driver
{
    /**
     * @param string $path
     * @return bool
     */
    public function load(string $path): bool;

    /**
     * @param string $path
     * @return bool
     */
    public function export(string $path): bool;
}