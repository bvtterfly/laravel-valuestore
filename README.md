# Laravel Valuestore

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bvtterfly/laravel-valuestore.svg?style=flat-square)](https://packagist.org/packages/bvtterfly/laravel-valuestore)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/bvtterfly/laravel-valuestore/run-tests?label=tests)](https://github.com/bvtterfly/laravel-valuestore/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/bvtterfly/laravel-valuestore/Check%20&%20fix%20styling?label=code%20style)](https://github.com/bvtterfly/laravel-valuestore/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/bvtterfly/laravel-valuestore.svg?style=flat-square)](https://packagist.org/packages/bvtterfly/laravel-valuestore)

This package makes it easy to store and retrieve some loose values. The values are saved as JSON/Yaml files. 
The package integrates with the Laravel filesystem and adds Yaml support by extending the `spatie/valuestore` package.

It can be used like this:

```php
use Bvttterfly\Valuestore\Valuestore;

$valuestore = Valuestore::make($filename);

$valuestore->put('key', 'value');

$valuestore->get('key'); // Returns 'value'

$valuestore->has('key'); // Returns true

// Specify a default value for when the specified key does not exist
$valuestore->get('non existing key', 'default') // Returns 'default'

$valuestore->put('anotherKey', 'anotherValue');

// Put multiple items in one go
$valuestore->put(['ringo' => 'drums', 'paul' => 'bass']);

$valuestore->all(); // Returns an array with all items

$valuestore->forget('key'); // Removes the item

$valuestore->flush(); // Empty the entire valuestore

$valuestore->flushStartingWith('somekey'); // remove all items whose keys start with "somekey"

$valuestore->increment('number'); // $valuestore->get('number') will return 1 
$valuestore->increment('number'); // $valuestore->get('number') will return 2
$valuestore->increment('number', 3); // $valuestore->get('number') will return 5

// Valuestore implements ArrayAccess
$valuestore['key'] = 'value';
$valuestore['key']; // Returns 'value'
isset($valuestore['key']); // Return true
unset($valuestore['key']); // Equivalent to removing the value

// Valuestore implements Countable
count($valuestore); // Returns 0
$valuestore->put('key', 'value');
count($valuestore); // Returns 1
```


## Installation

You can install the package via composer:

```bash
composer require bvtterfly/laravel-valuestore
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="valuestore-config"
```

This is the contents of the published config file:

```php
return [
    /*
    |--------------------------------------------------------------------------
    | Valuestore Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the filesystem disk that should be used
    | by the Valuestore.
    */
    'disk' => config('filesystems.default'),
];
```

## Usage

To create a Valuestore use the `make` method.

```php
$valuestore = Valuestore::make($pathToFile);
```

You can also pass some values as a second argument. These will be added to the valuestore using the `put` method.

```php
$valuestore = Valuestore::make($pathToFile, ['key' => 'value']);
```

All values will be saved as json/yaml in the given file.

When there are no values stored, the file will be deleted.

You can call the following methods on the `Valuestore`

### put
```php
/**
 * Put a value in the store.
 *
 * @param string|array $name
 * @param string|int|null $value
 * 
 * @return $this
 */
public function put($name, $value = null)
```

### get

```php
/**
 * Get a value from the store.
 *
 * @param string $name
 *
 * @return null|string
 */
public function get(string $name)
```

### has

```php
/*
 * Determine if the store has a value for the given name.
 */
public function has(string $name) : bool
```

### all
```php
/**
 * Get all values from the store.
 *
 * @return array
 */
public function all() : array
```

### allStartingWith
```php
/**
 * Get all values from the store which keys start with the given string.
 *
 * @param string $startingWith
 *
 * @return array
*/
public function allStartingWith(string $startingWith = '') : array
```

### forget
```php
/**
 * Forget a value from the store.
 *
 * @param string $key
 *
 * @return $this
 */
public function forget(string $key)
```

### flush
```php
/**
 * Flush all values from the store.
 *
 * @return $this
 */
 public function flush()
```

### flushStartingWith
```php
/**
 * Flush all values from the store which keys start with the specified value.
 *
 * @param string $startingWith
 *
 * @return $this
 */
 public function flushStartingWith(string $startingWith)
```

### pull
```php
/**
 * Get and forget a value from the store.
 *
 * @param string $name 
 *
 * @return null|string
 */
public function pull(string $name)
```

### increment
```php
/**
 * Increment a value from the store.
 *
 * @param string $name
 * @param int $by
 *
 * @return int|null|string
 */
 public function increment(string $name, int $by = 1)
```

### decrement
```php
/**
 * Decrement a value from the store.
 *
 * @param string $name
 * @param int $by
 *
 * @return int|null|string
 */
 public function decrement(string $name, int $by = 1)
```

## push
```php
/**
 * Push a new value into an array.
 *
 * @param string $name
 * @param $pushValue
 *
 * @return $this
 */
public function push(string $name, $pushValue)
```

## prepend
```php
/**
 * Prepend a new value into an array.
 *
 * @param string $name
 * @param $prependValue
 *
 * @return $this
 */
public function prepend(string $name, $prependValue)
```

## count
```php
/**
 * Count elements.
 *
 * @return int
 */
public function count()
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [ARI](https://github.com/bvtterfly)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
