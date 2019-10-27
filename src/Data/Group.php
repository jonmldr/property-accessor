<?php

namespace JonMldr\PropertyAccessor\Data;

class Group
{
    /**
     * @var Person[] | array
     */
    private $persons;

    public function __construct(array $persons)
    {
        $this->persons = $persons;
    }

    public function getPersons(): array
    {
        return $this->persons;
    }
}
