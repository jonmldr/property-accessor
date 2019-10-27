<?php

declare(strict_types=1);

namespace JonMldr\PropertyAccessor\Test;

use JonMldr\PropertyAccessor\AccessMethod\AccessMethodInterface;
use JonMldr\PropertyAccessor\AccessMethod\MethodAccessMethod;
use JonMldr\PropertyAccessor\AccessMethod\PropertyAccessMethod;
use JonMldr\PropertyAccessor\PropertyAccessor;
use JonMldr\PropertyAccessor\Test\Data\Car;
use PHPUnit\Framework\TestCase;

class PropertyAccessorTest extends TestCase
{
    /**
     * @var PropertyAccessor
     */
    private $propertyAccessor;

    /**
     * @var Car
     */
    private $car;

    protected function setUp(): void
    {
        $this->propertyAccessor = new PropertyAccessor();

        $this->car = new Car(
            'AA-01-BB',
            'Acme',
            'blue',
            true,
            false,
            [
                'John Doe',
                'Richard Roe',
            ],
            [
            ],
        );
    }

    public function testPublicProperty(): void
    {
        $accessMethod = $this->propertyAccessor->getAccessMethod('cOlOr', Car::class);
        $result = $this->propertyAccessor->getValue('cOlOr', $this->car);

        $this->assertInstanceOf(AccessMethodInterface::class, $accessMethod);
        $this->assertInstanceOf(PropertyAccessMethod::class, $accessMethod);

        $this->assertEquals('color', $accessMethod->getPropertyName());
        $this->assertEquals('blue', $result);
    }

    public function testGetter(): void
    {
        $accessMethod = $this->propertyAccessor->getAccessMethod('lIcEnSePlAtE', Car::class);
        $result = $this->propertyAccessor->getValue('lIcEnSePlAtE', $this->car);

        $this->assertInstanceOf(AccessMethodInterface::class, $accessMethod);
        $this->assertInstanceOf(MethodAccessMethod::class, $accessMethod);

        $this->assertEquals('getLicensePlate', $accessMethod->getMethodName());
        $this->assertEquals('AA-01-BB', $result);
    }

    public function testGetterWithUnderScore(): void
    {
        $accessMethod = $this->propertyAccessor->getAccessMethod('bRaNd', Car::class);
        $result = $this->propertyAccessor->getValue('bRaNd', $this->car);

        $this->assertInstanceOf(AccessMethodInterface::class, $accessMethod);
        $this->assertInstanceOf(MethodAccessMethod::class, $accessMethod);

        $this->assertEquals('get_brand', $accessMethod->getMethodName());
        $this->assertEquals('Acme', $result);
    }

    public function testIsser(): void
    {
        $accessMethod = $this->propertyAccessor->getAccessMethod('dIeSeL', Car::class);
        $result = $this->propertyAccessor->getValue('dIeSeL', $this->car);

        $this->assertInstanceOf(AccessMethodInterface::class, $accessMethod);
        $this->assertInstanceOf(MethodAccessMethod::class, $accessMethod);

        $this->assertEquals('isDiesel', $accessMethod->getMethodName());
        $this->assertEquals(true, $result);
    }

    public function testIsserWithUnderscore(): void
    {
        $accessMethod = $this->propertyAccessor->getAccessMethod('gAsOlIne', Car::class);
        $result = $this->propertyAccessor->getValue('gAsOlIne', $this->car);

        $this->assertInstanceOf(AccessMethodInterface::class, $accessMethod);
        $this->assertInstanceOf(MethodAccessMethod::class, $accessMethod);

        $this->assertEquals('is_gasoline', $accessMethod->getMethodName());
        $this->assertEquals(false, $result);
    }

    public function testHasser(): void
    {
        $accessMethod = $this->propertyAccessor->getAccessMethod('dRiVeRs', Car::class);
        $result = $this->propertyAccessor->getValue('dRiVeRs', $this->car);

        $this->assertInstanceOf(AccessMethodInterface::class, $accessMethod);
        $this->assertInstanceOf(MethodAccessMethod::class, $accessMethod);

        $this->assertEquals('hasDrivers', $accessMethod->getMethodName());
        $this->assertEquals(true, $result);
    }

    public function testHasserWithUnderscore(): void
    {
        $accessMethod = $this->propertyAccessor->getAccessMethod('oWnErS', Car::class);
        $result = $this->propertyAccessor->getValue('OWNERS', $this->car);

        $this->assertInstanceOf(AccessMethodInterface::class, $accessMethod);
        $this->assertInstanceOf(MethodAccessMethod::class, $accessMethod);

        $this->assertEquals('has_owners', $accessMethod->getMethodName());
        $this->assertEquals(false, $result);
    }
}
