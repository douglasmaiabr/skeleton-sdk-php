# Skeleton SDK PHP

## About

The `skeleton-sdk-php` package is a boilerplate SDK to get started with building SDK's

## Requirements

- PHP 7.3+

## Installation

Require the `juststeveking/skeleton-sdk-phpk` package in your `composer.json`:
```bash
composer require juststeveking/skeleton-sdk-php
```

## Configuration

Configuration is done through an instance of `JustSteveKing\SDK\Client`.

```php
// load Composer
require_once __DIR__ . '/vendor/autoload.php';

use JustSteveKing\SDK\Client;

$client = new Client([
    'url' => '{ your-api-domain }',
]);
```

Or configure after construct:

```php
$client = new Client();
$client->setUrl('https://api.domain.com');
```

## Testing

```bash
./vendor/bin/phpunit
```