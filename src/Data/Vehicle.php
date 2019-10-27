<?php

namespace JonMldr\PropertyAccessor\Data;

class Vehicle
{
    /**
     * @var string
     */
    private $licensePlate;

    public function __construct(string $licensePlate)
    {
        $this->licensePlate = $licensePlate;
    }

    public function getLicensePlate(): string
    {
        return $this->licensePlate;
    }
}
