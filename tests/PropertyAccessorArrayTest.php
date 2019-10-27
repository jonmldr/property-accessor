<?php

declare(strict_types=1);

namespace JonMldr\PropertyAccessor\Test;

use JonMldr\PropertyAccessor\Exception\InvalidPropertyPathSyntaxException;
use JonMldr\PropertyAccessor\PropertyAccessor;
use PHPUnit\Framework\TestCase;

class PropertyAccessorArrayTest extends TestCase
{
    /**
     * @var PropertyAccessor
     */
    private $propertyAccessor;

    /**
     * @var array
     */
    private $employees;

    protected function setUp(): void
    {
        $this->propertyAccessor = new PropertyAccessor();

        $this->employees = [
            [
                'name' => 'John Doe',
                'skills' => [
                    'programming' => [
                        'languages' => [
                            'PHP' => 89,
                        ]
                    ]
                ],
            ]
        ];
    }

    public function testValidSyntax(): void
    {
        $result = $this->propertyAccessor->getValue('[0][name]', $this->employees);

        $this->assertEquals('John Doe', $result);
    }

    public function testInvalidSyntax(): void
    {
        $this->expectException(InvalidPropertyPathSyntaxException::class);

        $this->propertyAccessor->getValue('0.name', $this->employees);
    }

    public function testNestedAccess(): void
    {
        $result = $this->propertyAccessor->getValue('[0][skills][programming][languages][PHP]', $this->employees);

        $this->assertEquals(89, $result);
    }
}
