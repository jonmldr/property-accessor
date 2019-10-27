<?php

namespace JonMldr\PropertyAccessor\Data;

class Person
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Vehicle[] | array
     */
    public $vehicles;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVehicles(): array
    {
        return $this->vehicles;
    }
}
