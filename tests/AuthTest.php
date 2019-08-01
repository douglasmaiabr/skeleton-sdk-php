<?php

namespace JustSteveKing\SDK\Tests;

use JustSteveKing\SDK\Client;
use PHPUnit\Framework\TestCase;
use JustSteveKing\SDK\Support\Auth;

class AuthTest extends TestCase
{
    protected $auth;

    protected $client;

    protected $initialConfig = [
        'url' => 'https://test.domain.com/api'
    ];

    public function setUp() : void
    {
        parent::setUp();

        $this->client = new Client($this->initialConfig);
        $this->auth = $this->client->getAuth();
    }

    /**
     * Test that you can set and get Auth Strategy on Auth
     * 
     * @test
     */
    public function SetAndGetAuthStrategy()
    {
        $this->auth->setAuthStrategy('oauth');
        $this->assertEquals('oauth', $this->auth->getAuthStrategy());
    }

    /**
     * Test that you can set and get Auth Options on Auth
     * 
     * @test
     */
    public function SetAndGetAuthOptions()
    {
        $options = [
            'username' => 'user@email.com',
            'password' => 'password'
        ];

        $this->auth->setAuthOptions($options);
        $this->assertEquals($options, $this->auth->getAuthOptions());
    }
}
