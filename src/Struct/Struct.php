<?php

namespace AdamDBurton\Destiny2ApiClient\Struct;

use AdamDBurton\Destiny2ApiClient\Enum\Enum;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidAttribute;
use AdamDBurton\Destiny2ApiClient\Exception\InvalidAttributeType;
use ReflectionClass;
use ReflectionProperty;

abstract class Struct
{
	private $data = [];

	/**
	 * Structure constructor.
	 * @param array $data
	 * @throws InvalidAttribute
	 * @throws InvalidAttributeType
	 */
	public function __construct(array $data = [])
	{
		foreach($data as $attribute => $value)
		{
			$this->setAttribute($attribute, $value);
		}
	}

	public function toArray()
	{
		return $this->data;
	}

	/**
	 * @param $name
	 * @param $arguments
	 * @return $this
	 * @throws InvalidAttribute
	 * @throws InvalidAttributeType
	 */
	public function __call($name, $arguments)
	{
		$this->setAttribute($name, $arguments[0]);

		return $this;
	}

	/**
	 * @param $attribute
	 * @param $value
	 * @throws InvalidAttribute
	 * @throws InvalidAttributeType
	 */
	public function setAttribute($attribute, $value)
	{
		if(!$this->hasAttribute($attribute))
		{
			throw new InvalidAttribute(get_class($this), $name);
		}

		$type = $this->$attribute;

		if(class_exists($type) && is_subclass_of($type, Enum::class))
		{
			// Got an enum type, make sure the enum contains the value

			$enumClass = new $type;

			if(!$enumClass->hasEnum($value))
			{
				$exceptionClass = $enumClass->getException();

				throw new $exceptionClass($value);
			}
		}
		elseif(preg_match('/(.*)\[\]$/', $type, $matches))
		{
			// Class array type, like \Namespace\SomeClass[]
			// We want to check that every value in the supposed array has the specified class (or is a subclass of it)

			if(!is_array($value))
			{
				throw new InvalidAttributeType($attribute, 'array');
			}

			$classType = $matches[1];

			foreach($value as $item)
			{
				if(!is_object($item) || !is_subclass_of($item, $classType))
				{
					throw new InvalidAttributeType($attribute, $classType);
				}
			}
		}
		elseif(gettype($value) != $type)
		{
			// Standard php type, but type equality

			throw new InvalidAttributeType($attribute, $type);
		}

		$this->data[$attribute] = $value;
	}

	/**
	 * @param $attribute
	 * @return mixed|null
	 */
	public function getAttribute($attribute)
	{
		return isset($this->data[$attribute]) ? $this->data[$attribute] : null;
	}

	/**
	 * @param $attribute
	 * @return bool
	 */
	private function hasAttribute($attribute)
	{
		return in_array($attribute, self::getAttributes());
	}

	/**
	 * @return ReflectionProperty[]
	 */
	public static function getAttributes()
	{
		$class = new ReflectionClass(get_called_class());

		return $class->getProperties(ReflectionProperty::IS_PROTECTED);
	}
}