Collection Component
=======


### Requirements
 - PHP >= 5.4
 
### Installation
```sh
$ composer require kasseler/collection
```

### Usage

```php
$collection = new ArrayCollection([
    'one' => 1,
    'two' => 2,
    'three' => 3,
    'four' => 4,
    'five' => 5,
]);

echo $collection->get('one'); // return one key
echo $collection->two; // return two key
echo $collection['three']; // return three key

foreach ($collection as $key => $value) {
    /*
    * return
    * key[one]   = '1';
    * key[two]   = '2';
    * key[three] = '3';
    * key[four]  = '4';
    * key[five]  = '5';
    */
    echo sprintf("\nkey[%s] = '%s';", $key, $value);
}

echo $collection; //return serialize array

unset($collection['four']);
$collection->remove('five');

echo count($collection); // return 3
```