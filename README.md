# PropertyAccessor

This PropertyAccessor allows you to access properties using getters, issers, hassers, 
or directly if the property is public.

This library also provides a `getAccessMethod` function, which returns a implementation of the `AccessMethodInterface`.
This function tells you how the property will be accessed.

## Example
Value
````PHP
$propertyAccessor = new PropertyAccessor();
// Will throw an `NoAccessMethodException` if there is no method to access the property.
$result = $propertyAccessor->getValue('users[0].repositories[0].name', $group);
````

Access method
````PHP
$accessMethod = $this->propertyAccessor->getAccessMethod('licensePlate', Car::class);

if ($accessMethod instanceof MethodAccessMethod) {
    // The value wil be accessed by a method.
    $methodName = $accessMethod->getMethodName();
} elseif ($accessMethod instanceof ProperyAccessMethod) {
    // The value wil be accessed by a (public) property.
    $propertyName = $accessMethod->getPropertyName();
} elseif ($accessMethod === null) {
    // No access method found.
}
````

## Tests
Run the unit tests by executing the following command:
````
./vendor/bin/phpunit tests/ --colors=auto
````
