<?php

namespace AdamDBurton\Destiny2ApiClient\Contract;

use stdClass;

/**
 * @package AdamDBurton\Destiny2ApiClient\Contract
 */
interface Driver
{
    /**
     * @param string $type
     * @param string $hash
     * @return array
     */
    public function getDefinition(string $type, string $hash): array;

    /**
     * @param string $type
     * @param string[] $hashes
     * @return stdClass[]
     */
    public function getDefinitions(string $type, array $hashes): array;

    /**
     * @param string $path
     * @return bool
     */
    public function exportToFile(string $path): bool;

    /**
     * @param string $path
     * @return bool
     */
    public function exportToDirectory(string $path): bool;
}