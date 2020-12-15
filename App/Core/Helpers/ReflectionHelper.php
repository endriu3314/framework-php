<?php

namespace App\Core\Helpers;

use ReflectionClass;
use ReflectionProperty;

class ReflectionHelper
{
    public static function getPrivatePropertyValue($class, string $propertyName): mixed
    {
        $reflectionClass = new ReflectionClass($class);
        $property = $reflectionClass->getProperty($propertyName);
        $property->setAccessible(true);
        return $property->getValue($class);
    }

    public static function getPublicProperties($class): array
    {
        $reflectionClass = new ReflectionClass($class);

        $properties = [];

        foreach ($reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $propertyName = $property->getName();
            $properties[] = $propertyName;
        }

        return $properties;
    }

    public static function getNonNullPublicProperties($class): array
    {
        $reflectionClass = new ReflectionClass($class);

        $properties = [];

        foreach ($reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $propertyName = $property->getName();
            $propertyValue = $property->getValue($class);

            if ($propertyValue != '') {
                $properties[] = $propertyName;
            }
        }

        return $properties;
    }

    public static function getPublicPropertiesValues($class): array
    {
        $reflectionClass = new ReflectionClass($class);

        $properties = [];

        foreach (self::getNonNullPublicProperties($class) as $property) {
            $propertyValue = $reflectionClass->getProperty($property)->getValue($class);
            $properties[$property] = $propertyValue;
        }

        return $properties;
    }

    public static function setFieldsToReflectionClass($class, array $data): void
    {
        $properties = self::getPublicProperties($class);
        $reflectionClass = new ReflectionClass($class);

        foreach ($properties as $property) {
            $reflectionClass->getProperty($property)->setValue($class, $data[$property]);
        }
    }
}
