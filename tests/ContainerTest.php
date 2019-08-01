<?php

namespace JustSteveKing\SDK\Tests;

use JustSteveKing\SDK\Client;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
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
     * Test that I can add a class onto the container
     * 
     * @test
     */
    public function AddClassToContainer()
    {
        $container = $this->client->getContainer();
        $container->add(\JustSteveKing\SDK\Tests\DummyClass::class);
        $this->assertTrue($container->has(\JustSteveKing\SDK\Tests\DummyClass::class));
    }

    /**
     * Test that I can add a class onto the container using an alias
     * 
     * @test
     */
    public function AddClassToContainerWithAlias()
    {
        $container = $this->client->getContainer();
        $container->add('dummy', \JustSteveKing\SDK\Tests\DummyClass::class);
        $this->assertTrue($container->has('dummy'));
    }
}