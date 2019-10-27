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
        $parts = explode('.', $propertyPath);

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

            throw new NoAccessMethodException();
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

        if ($this->isPublicProperty($propertyName)) {
            return new PropertyAccessMethod($propertyName);
        }

        $method = $this->findPublicMethod($propertyName);
        if ($method !== null) {
            return new MethodAccessMethod($method);
        }

        return null;
    }

    private function isPublicProperty(string $propertyName): bool
    {
        try {
            $reflectionProperty = $this->reflectionClass->getProperty($propertyName);

            return $reflectionProperty->isPublic();
        } catch (ReflectionException $e) {
        }

        return false;
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
}
