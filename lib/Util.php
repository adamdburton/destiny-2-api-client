<?php

namespace AdamDBurton\Destiny2ApiClient;

/**
 * API utility functions.
 * @package AdamDBurton\Destiny2ApiClient
 */
class Util
{
    /**
     * Converts an unsigned int from a Destiny SQLite manifest file into a signed int.
     * @param int $hash
     * @return int
     */
    public static function convertHash(int $hash): int
    {
        return $hash < 0 ? $hash + 4294967296 : $hash;
    }

    /**
     * Converts an array of unsigned ints into signed ints.
     * @param int[] $hashes
     * @return int[]
     */
    public static function convertHashes($hashes): array
    {
        return array_map(function ($hash) {
            return self::convertHash($hash);
        }, $hashes);
    }
}