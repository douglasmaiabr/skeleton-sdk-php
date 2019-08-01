<?php

namespace JustSteveKing\SDK\Tests;

use JustSteveKing\SDK\Client;
use League\Container\Container;
use PHPUnit\Framework\TestCase;
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
    public function SetupConfiguresUrl()
    {
        $this->assertEquals($this->initialConfig['url'], $this->client->getUrl());
    }

    /**
     * Test that I can set Resources on Client
     * 
     * @test
     */
    public function SetResourcesOnClient()
    {
        $this->client->setResources(['key' => 'value']);
        $this->assertTrue(array_key_exists('key', $this->client->getResources()));
    }

    /**
     * Test that I can get Resources from Client
     * 
     * @test
     */
    public function GetResourcesOnClient()
    {
        $this->client->setResources(['key' => 'value']);
        $this->assertEquals(count($this->client->getResources()), 1);
    }

    /**
     * Test that I can get User Agent
     * 
     * @test
     */
    public function GetUserAgent()
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
    public function SetUserAgent()
    {
        $userAgent = 'phpunit-sdk-test';
        $this->client->setUserAgent($userAgent);
        $this->assertEquals($userAgent, $this->client->getUserAgent());
    }

    /**
     * Test after construct our client has guzzle available
     * 
     * @test
     */
    public function ClientHasGuzzle()
    {
        $this->assertInstanceOf(HttpClient::class, $this->client->getGuzzle());
    }

    /**
     * Test after construct our client has our container available
     * 
     * @test
     */
    public function ClientHasContainer()
    {
        $this->assertInstanceOf(Container::class, $this->client->getContainer());
    }
}
