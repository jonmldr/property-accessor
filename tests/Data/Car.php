<?php

declare(strict_types=1);

namespace JonMldr\PropertyAccessor\Test\Data;

class Car
{
    /**
     * @var string
     */
    private $licensePlate;

    /**
     * @var string
     */
    private $brand;

    /**
     * @var string
     */
    public $color;

    /**
     * @var bool
     */
    private $diesel;

    /**
     * @var bool
     */
    private $gasoline;

    /**
     * string[] | array
     */
    private $drivers;

    /**
     * string[] | array
     */
    private $owners;

    public function __construct(
        string $licensePlate,
        string $brand,
        string $color,
        bool $diesel,
        bool $gasoline,
        array $drivers,
        array $owners
    ) {
        $this->licensePlate = $licensePlate;
        $this->brand = $brand;
        $this->color = $color;
        $this->diesel = $diesel;
        $this->gasoline = $gasoline;
        $this->drivers = $drivers;
        $this->owners = $owners;
    }

    public function getLicensePlate(): string
    {
        return $this->licensePlate;
    }

    public function get_brand(): string
    {
        return $this->brand;
    }

    public function isDiesel(): bool
    {
        return $this->diesel;
    }

    public function is_gasoline(): bool
    {
        return $this->gasoline;
    }

    public function hasDrivers(): bool
    {
        return count($this->drivers) > 0;
    }

    public function has_owners(): bool
    {
        return count($this->owners) > 0;
    }
}
