<?php

namespace AdamDBurton\Destiny2ApiClient;

use ReflectionClass;
use ReflectionException;

/**
 * @package AdamDBurton\Destiny2ApiClient\Enum
 */
abstract class Enum
{
    /**
     * @return array
     */
    public static function getEnums()
    {
        try {
            $class = new ReflectionClass(get_called_class());

            return $class->getConstants();
        } catch (ReflectionException $e) {
        }
    }

    /**
     * @return array
     */
    public static function getEnumStrings()
    {
        return array_keys(self::getEnums());
    }

    /**
     * @param $constant
     * @return mixed
     */
    public static function getEnumStringFor($constant)
    {
        $flipped = array_flip(self::getEnums());

        return $flipped[$constant];
    }

    /**
     * @param $constants
     * @return array
     */
    public static function getEnumStringsFor($constants)
    {
        if (!is_array($constants)) {
            $constants = [$constants];
        }

        $flipped = array_flip(self::getEnums());

        $mapped = array_map(function ($value) use ($flipped) {
            return $flipped[$value];
        }, $constants);

        return array_filter($mapped);
    }

    /**
     * @param $enum
     * @return bool
     */
    public static function hasEnum($enum)
    {
        return in_array($enum, self::getEnums());
    }
}