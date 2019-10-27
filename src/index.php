<?php

use JonMldr\PropertyAccessor\Data\Group;
use JonMldr\PropertyAccessor\Data\Person;
use JonMldr\PropertyAccessor\Data\Vehicle;
use JonMldr\PropertyAccessor\PropertyAccessor;

include '../vendor/autoload.php';

$vehicle = new Vehicle('SX-DL-15');
$person = new Person('John Doe');
$person->vehicles = [$vehicle];
$group = new Group([$person]);

$propertyAccessor = new PropertyAccessor();
$result = $propertyAccessor->getValue('persons[0].vehicles[0].licensePlate', $group);

dd($result);
