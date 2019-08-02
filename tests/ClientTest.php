<?php

namespace JustSteveKing\SDK\Tests;

use stdClass;
use JustSteveKing\SDK\Client;
use League\Container\Container;
use PHPUnit\Framework\TestCase;
use JustSteveKing\SDK\Support\Auth;
use GuzzleHttp\Client as HttpClient;

class ClientTest extends TestCase
{
    protected $client;

    protected $initialConfig = [
        'url' => 'https://test.domain.com/api'
    ];

    public function setUp() : void
    {
        parent::setUp();

        $this->client = new Client($this->initialConfig);
    }

    /**
     * Test that setUp configured the URL
     * 
     * @test
     */
    public function setupConfiguresUrl()
    {
        $this->assertEquals($this->initialConfig['url'], $this->client->getUrl());
    }

    /**
     * Test that I can set Resources on Client
     * 
     * @test
     */
    public function setResourcesOnClient()
    {
        $this->client->setResources(['key' => 'value']);
        $this->assertTrue(array_key_exists('key', $this->client->getResources()));
    }

    /**
     * Test that I can get Resources from Client
     * 
     * @test
     */
    public function getResourcesOnClient()
    {
        $this->client->setResources(['key' => 'value']);
        $this->assertEquals(count($this->client->getResources()), 1);
    }

    /**
     * Test that I can get User Agent
     * 
     * @test
     */
    public function getUserAgent()
    {
        $version = $this->client::VERSION;
        $this->assertEquals(
            "PHP SDK {$version}",
            $this->client->getUserAgent()
        );
    }

    /**
     * Test that I can set User Agent
     * 
     * @test
     */
    public function setUserAgent()
    {
        $userAgent = 'phpunit-sdk-test';
        $this->client->setUserAgent($userAgent);
        $this->assertEquals($userAgent, $this->client->getUserAgent());
    }

    /**
     * Test that I can set and get User Credentials
     * 
     * @test
     */
    public function setAndGetUserCredentials()
    {
        $credentials = new stdClass();
        $this->assertInstanceOf(stdClass::class, $credentials);
        $credentials->token_type = "Bearer";
        $credentials->expires_in = 1296000;
        $credentials->access_token = "1234567890";
        $credentials->refresh_token = "1234567890";

        $this->client->setCredentials($credentials);
        $this->assertInstanceOf(stdClass::class, $this->client->getCredentials());
    }

    /**
     * Test after construct our client has guzzle available
     * 
     * @test
     */
    public function clientHasGuzzle()
    {
        $this->assertInstanceOf(HttpClient::class, $this->client->getGuzzle());
    }

    /**
     * Test after construct our client has our container available
     * 
     * @test
     */
    public function clientHasContainer()
    {
        $this->assertInstanceOf(Container::class, $this->client->getContainer());
    }
}
