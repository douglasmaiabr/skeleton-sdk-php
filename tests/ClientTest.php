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
