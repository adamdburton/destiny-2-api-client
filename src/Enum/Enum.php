<?php

namespace AdamDBurton\Destiny2ApiClient\Enum;

use ReflectionClass;

abstract class Enum
{
	public static function getEnums()
	{
		$class = new ReflectionClass(get_called_class());

		return $class->getConstants();
	}

	public static function getEnumStrings()
	{
		return array_keys(self::getEnums());
	}

	public static function getEnumStringFor($constant)
	{
		$flipped = array_flip(self::getEnums());

		return $flipped[$constant];
	}

	public static function getEnumStringsFor($constants)
	{
		$flipped = array_flip(self::getEnums());

		$mapped = array_map(function($value) use ($flipped)
		{
			return $flipped[$value];
		}, $constants);

		return array_filter($mapped);
	}

	public static function hasEnum($enum)
	{
		return in_array($enum, self::getEnums());
	}
}