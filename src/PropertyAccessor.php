<?php

declare(strict_types=1);

namespace JonMldr\PropertyAccessor;

use JonMldr\PropertyAccessor\AccessMethod\AccessMethodInterface;
use JonMldr\PropertyAccessor\AccessMethod\MethodAccessMethod;
use JonMldr\PropertyAccessor\AccessMethod\PropertyAccessMethod;
use JonMldr\PropertyAccessor\Exception\NoAccessMethodException;
use ReflectionClass;
use ReflectionException;

class PropertyAccessor
{
    /**
     * @var ReflectionClass
     */
    private $reflectionClass;

    /**
     * @throws NoAccessMethodException
     */
    public function getValue(string $propertyPath, $arrayOrObject)
    {
        $parts = $this->getPropertyPathParts($propertyPath);

        $io = $arrayOrObject;
        foreach ($parts as $part)
        {
            $io = $this->getValueOfSingleItem($part, $io);
        }

        return $io;
    }

    /**
     * @throws NoAccessMethodException
     */
    private function getValueOfSingleItem(string $propertyName, $arrayOrObject)
    {
        if (is_array($arrayOrObject)) {
            if (array_key_exists($propertyName, $arrayOrObject) === true) {
                return $arrayOrObject[$propertyName];
            }

            throw new NoAccessMethodException(sprintf("Unable to access array key '%s' on set '%s'", $propertyName, print_r($arrayOrObject, true)));
        }

        $class = get_class($arrayOrObject);
        $accessMethod = $this->getAccessMethod($propertyName, $class);

        if ($accessMethod === null) {
            throw new NoAccessMethodException();
        }

        if ($accessMethod instanceof PropertyAccessMethod) {
            $propertyName = $accessMethod->getPropertyName();

            return $arrayOrObject->$propertyName;
        }

        if ($accessMethod instanceof MethodAccessMethod) {
            $methodName = $accessMethod->getMethodName();

            return $arrayOrObject->$methodName();
        }

        throw new NoAccessMethodException();
    }

    public function getAccessMethod(string $propertyName, string $class): ?AccessMethodInterface
    {
        try {
            $this->reflectionClass = new ReflectionClass($class);
        } catch (ReflectionException $e) {
            return null;
        }

        $property = $this->findPublicProperty($propertyName);
        if ($property !== null) {
            return new PropertyAccessMethod($property);
        }

        $method = $this->findPublicMethod($propertyName);
        if ($method !== null) {
            return new MethodAccessMethod($method);
        }

        return null;
    }

    private function findPublicProperty(string $propertyName): ?string
    {
        $properties = $this->reflectionClass->getProperties();

        foreach ($properties as $property) {
            if (strtolower($property->getName()) !== strtolower($propertyName)) {
                continue;
            }

            if ($property->isPublic()) {
                return $property->getName();
            }
        }

        return null;
    }

    private function findPublicMethod(string $propertyName): ?string
    {
        $methodNames = [
            sprintf('get%s', $propertyName),
            sprintf('get_%s', $propertyName),
            sprintf('is%s', $propertyName),
            sprintf('is_%s', $propertyName),
            sprintf('has%s', $propertyName),
            sprintf('has_%s', $propertyName),
            $propertyName,
        ];

        foreach ($methodNames as $methodName) {
            try {
                $reflectionMethod = $this->reflectionClass->getMethod($methodName);

                if ($reflectionMethod->isPublic() && $reflectionMethod->getNumberOfRequiredParameters() === 0) {
                    return $reflectionMethod->getName();
                }
            } catch (ReflectionException $e) {
            }
        }

        return null;
    }

    private function getPropertyPathParts(string $propertyPath): array
    {
        $parts = explode('.', $propertyPath);

        $data = [];
        foreach ($parts as $part) {
            $arrayParts = explode('[', $part);

            foreach ($arrayParts as $arrayPart) {
                $data[] = str_replace(['[', ']'], ['', ''], $arrayPart);
            }
        }

        return array_filter($data, function ($key) {
            return $key !== '';
        });
    }
}
