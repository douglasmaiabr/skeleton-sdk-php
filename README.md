# Skeleton SDK PHP

## About

The `skeleton-sdk-php` package is a boilerplate SDK to get started with building SDK's

## Requirements

- PHP 7.3
- guzzlehttp/guzzle
- league/container

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

## Indepth Usage

#### Configuring our Client

To begin using the SDK you need to first off get your client set up, see `examples/test.php` or:

```php
use Dotenv\Dotenv;
use JustSteveKing\SDK\Client;
use JustSteveKing\SDK\Http\OAuth;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::create(__DIR__);
$dotenv->load();

$config = [
    'url' => getenv('API_URL'),
    'client_id' => getenv('CLIENT_ID'),
    'client_secret' => getenv('CLIENT_SECRET'),
    'username' => getenv('USERNAME'),
    'password' => getenv('PASSWORD'),
    'endpoint' => getenv('OAUTH_ENDPOINT')
];

$client = new Client($config);
```

At this stage you have a fully working Client to work with. If you have endpoints that do not require `Authentication`, then you can skip the next step.

##### Setting up Authentication

Currently I have only tested the `OAUTH` strategy:

```php
$auth = $client->setOauth();
```

That is it for OAuth! We previously passed in the credentials needed, however if you skipped that step you can add them still:

```php
$client->setUsername(getenv('USERNAME'))
    ->setPassword(getenv('PASSWORD'))
    ->setClientID(getenv('CLIENT_ID'))
    ->setClientSecret(getenv('CLIENT_SECRET'))
    ->setOAuthEndpoint(getenv('OAUTH_ENDPOINT'));
```

If you had to follow the above `setter` methods then you will need to run `$client->setOAuth()` still.


#### Working with Resources

By default this `sdk` does not come with any resources.

## Testing

```bash
./vendor/bin/phpunit
```