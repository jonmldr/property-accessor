<?php

declare(strict_types=1);

namespace JonMldr\PropertyAccessor\Test;

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
    private $data;

    protected function setUp(): void
    {
        $this->propertyAccessor = new PropertyAccessor();

        $this->data = [
            'employees' => [
                [
                    'name' => 'John Doe',
                    'skills' => [
                        'programming' => [
                            'languages' => [
                                'PHP' => 89,
                            ]
                        ]
                    ],
                ],
            ]
        ];
    }

    public function testValidSyntax(): void
    {
        $result = $this->propertyAccessor->getValue('employees[0].name', $this->data);

        $this->assertEquals('John Doe', $result);
    }

    public function testNestedAccess(): void
    {
        $result = $this->propertyAccessor->getValue('employees[0][skills][programming][languages][PHP]', $this->data);

        $this->assertEquals(89, $result);
    }
}
