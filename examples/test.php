<?php

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
$auth = $client->setOAuth();

dump($client->getCredentials());
