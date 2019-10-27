<?php

declare(strict_types=1);

namespace JonMldr\PropertyAccessor\AccessMethod;

class PropertyAccessMethod implements AccessMethodInterface
{
    /**
     * @var string
     */
    private $propertyName;

    public function __construct(string $propertyName)
    {
        $this->propertyName = $propertyName;
    }

    public function getPropertyName(): string
    {
        return $this->propertyName;
    }
}
