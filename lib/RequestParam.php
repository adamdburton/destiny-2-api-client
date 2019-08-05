<?php

namespace AdamDBurton\Destiny2ApiClient;

use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidAttribute;
use AdamDBurton\Destiny2ApiClient\Exception\Validation\InvalidAttributeType;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

/**
 * @package AdamDBurton\Destiny2ApiClient
 */
abstract class RequestParam
{
    private $data = [];

    /**
     * @param array $data
     * @throws ReflectionException
     * @throws InvalidAttributeType
     * @throws InvalidAttribute
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $attribute => $value) {
            $this->setAttribute($attribute, $value);
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this
     * @throws ReflectionException
     * @throws InvalidAttributeType
     * @throws InvalidAttribute
     */
    public function __call($name, $arguments)
    {
        $this->setAttribute($name, $arguments[0]);

        return $this;
    }

    /**
     * @param $attribute
     * @param $value
     * @throws ReflectionException
     * @throws InvalidAttributeType
     * @throws InvalidAttribute
     */
    public function setAttribute($attribute, $value)
    {
        if (!$this->hasAttribute($attribute)) {
            throw new InvalidAttribute(get_class($this), $name);
        }

        $type = $this->$attribute;

        if (class_exists($type) && is_subclass_of($type, Enum::class)) {
            // Simple class extending Enum

            /** @var Enum $enumClass */
            $enumClass = new $type;

            if (!$enumClass->hasEnum($value)) {
                $exceptionClass = $enumClass->getException();
                throw new $exceptionClass($value);
            }

            $this->data[$attribute] = $value;
        } elseif (preg_match('/(.*)\[\]$/', $type, $matches)) {
            // Class array type, like \Namespace\SomeClass[]
            // We want to check that every value in the supposed array is a subclass of the passed Enum class

            if (!is_array($value)) {
                throw new InvalidAttributeType($attribute, 'array');
            }

            $classType = $matches[1];

            foreach ($value as $item) {
                if (!is_object($item) || !is_subclass_of($item, Enum::class)) {
                    throw new InvalidAttributeType($attribute, $classType);
                }
            }
        } elseif (gettype($value) != $type) {
            throw new InvalidAttributeType($attribute, $type);
        }
    }

    /**
     * @param $attribute
     * @param null $default
     * @return mixed|null
     */
    public function getAttribute($attribute, $default = null)
    {
        return $this->data[$attribute] ?? $default;
    }

    /**
     * @param $attribute
     * @return bool
     * @throws ReflectionException
     */
    private function hasAttribute($attribute)
    {
        return in_array($attribute, self::getAttributes());
    }

    /**
     * @return ReflectionProperty[]
     * @throws ReflectionException
     */
    public static function getAttributes()
    {
        $class = new ReflectionClass(get_called_class());

        return $class->getProperties(ReflectionProperty::IS_PROTECTED);
    }
}