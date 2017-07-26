# Consul KV Array Getter

[![Build Status](https://travis-ci.org/rstgroup/php-consul-kv-array-getter.svg?branch=master)](https://travis-ci.org/rstgroup/php-consul-kv-array-getter)

## What does this library do?

The library allows you to retrieve whole tree of properties from Consul's KV store. Retrieved data is grouped into
nested arrays. 

## How to install it?

Require the package by Composer:

```bash
composer require rstgroup/php-consul-kv-array-getter
```

## How to use the library?

All you need is instance of `SensioLabs\Consul\Services\KVInterface` and pass it to
the `RstGroup\PhpConsulKVArrayGetter\Consul\ConsulArrayGetter` constructor:

```php
use SensioLabs\Consul\ServiceFactory;
use SensioLabs\Consul\Services\KVInterface;
use RstGroup\PhpConsulKVArrayGetter\Consul\ConsulArrayGetter;

// your consul options:
$consulParams = [
    'base_uri' => 'http://consul-domain:8500'
];

// prepare service that talks to Consul KV
$consulServicesFactory = new ServiceFactory($consulParams);
$kvService = $consulServicesFactory->get(KVInterface::class);

// create getter instance
$consulArrayGetter = new ConsulArrayGetter(
    $kvService
);

// get the keys as structure
$result = $consulArrayGetter->getByPrefix('prefix');

```

## How keys are mapped to return structure?

Let's assume we have list of keys present in KV Store:

```
application/db/host      => 'some host'
application/cache/prefix => 'abcd.prefix'
application/name         => 'app'
```

If we fetch config with prefix `'application'` we will receive:

```php
$consulArrayGetter->getByPrefix('application') == [
    'application' => [
        'db' => [ 'host' => 'some host' ],
        'cache' => [ 'prefix' => 'abcd.prefix' ],
        'name' => 'app'
    ]
]
```

If you add slash at the end, the result array will be created relative to
`application` key:

```php
$consulArrayGetter->getByPrefix('application/') == [
    'db' => [ 'host' => 'some host' ],
    'cache' => [ 'prefix' => 'abcd.prefix' ],
    'name' => 'app'
]
```

Adding another key part after slash will return only those keys that match given prefix:

```php
$consulArrayGetter->getByPrefix('application/db') == [
    'db' => [ 'host' => 'some host' ]
]
```
