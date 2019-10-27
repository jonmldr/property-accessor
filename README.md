# PropertyAccessor

## Example

````PHP
<?php

class Group
{
    /** @var Person[] | array */
    private $persons;

    (...)

    public function getPersons(): array
    {
        return $this->persons;
    }
}

class Person
{
    /** @var Vehicle[] | array */
    public $vehicles;
}

class Vehicle
{
    /** @var string */
    private $licensePlate;

    (...)

    public function getLicensePlate(): string
    {
        return $this->licensePlate;
    }
}

$vehicle = new Vehicle('AA-11-BB');
$person = new Person();
$person->vehicles = [$vehicle];
$group = new Group([$person]);

$propertyAccessor = new PropertyAccessor();
$result = $propertyAccessor->getValue('persons[0].vehicles[0].licensePlate', $group);
// Returns 'AA-11-BB'

````

## Tests
Run the unit tests by executing the following command:
````
./vendor/bin/phpunit tests/ --colors=auto
````
