<?php

declare(strict_types=1);

namespace JonMldr\PropertyAccessor\AccessMethod;

class MethodAccessMethod implements AccessMethodInterface
{
    /**
     * @var string
     */
    private $methodName;

    public function __construct(string $methodName)
    {
        $this->methodName = $methodName;
    }

    public function getMethodName(): string
    {
        return $this->methodName;
    }
}
