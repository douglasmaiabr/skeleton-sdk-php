<?php

namespace JustSteveKing\SDK;

use League\Container\Container;
use JustSteveKing\SDK\Http\OAuth;
use JustSteveKing\SDK\Support\Auth;
use GuzzleHttp\Client as HttpClient;
use JustSteveKing\SDK\Exceptions\APIResponseException;
use JustSteveKing\SDK\Exceptions\Auth\InvalidAuthenticationStrategyException;

class Client
{
    const VERSION = 'v1.0.0';

    /**
     * @var String
     */
    protected $url;

    /**
     * @var String
     */
    protected $userAgent = 'PHP SDK ' . self::VERSION;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var array
     */
    protected $authParams = [];

    /**
     * @var array
     */
    protected $resources = [];

    /**
     * @var object
     */
    protected $credentials;

    /**
     * @var Auth
     */
    protected $auth;

    /**
     * @var HttpClient
     */
    protected $guzzle;

    /**
     * @var Container
     */
    protected $container;

    /**
     * Create a new instance of our Client
     * 
     * @param   array   $options    The configuration options for our client
     * 
     * @return  void
     */
    public function __construct(array $options = [])
    {
        $options = array_merge([
            'url' => null
        ], $options);

        $this->setUrl($options['url']);
        $this->setAuthParams($options);
        $this->boot();
    }

    /**
     * Set our SDK Base URL
     * 
     * @param   String  $url    Our SDK Base URL
     * 
     * @return  void
     */
    public function setUrl(String $url) : void
    {
        $this->url = $url;
    }

    /**
     * Get our SDK Base URL
     * 
     * @return  null|String
     */
    public function getUrl() :? String
    {
        return $this->url;
    }

    /**
     * Set our SDK Auth Params
     * 
     * @param   array  $params
     * 
     * @return  void
     */
    public function setAuthParams(array $params) : void
    {
        $this->authParams = $params;
    }

    /**
     * Get our SDK Auth Params
     * 
     * @return  array
     */
    public function getAuthParams() : array
    {
        return $this->authParams;
    }

    /**
     * Get an instance of Container
     *
     * @return Container
     */
    public function getContainer() : Container
    {
        return $this->container;
    }

    /**
     * Get an instance of HttpClient
     *
     * @return HttpClient
     */
    public function getGuzzle() : HttpClient
    {
        return $this->guzzle;
    }

    /**
     * Get the Client Headers
     *
     * @return array
     */
    public function getHeaders() : array
    {
        return $this->headers;
    }

    /**
     * Set Client Header
     *
     * @param   String  $key
     * @param   String  $value
     *
     * @return  $this
     */
    public function setHeader(String $key, String $value)
    {
        $this->headers[$key] = $value;

        return $this;
    }

    /**
     * Set Resources onto the Container
     *
     * @param   array   $resources
     *
     * @return  void
     */
    public function setResources(array $resources) : void
    {
        foreach ($resources as $key => $value) {
            $this->resources[$key] = $value;
            $this->container->add($key, $value);
        }
    }

    /**
     * Get Resources on the Container
     *
     * @return  array
     */
    public function getResources() : array
    {
        return $this->resources;
    }

    /**
     * Return the User Agent String
     *
     * @return String
     */
    public function getUserAgent() : String
    {
        return $this->userAgent;
    }

    /**
     * Set the User Agent String
     *
     * @param   String  $string
     *
     * @return void
     */
    public function setUserAgent(String $string) : void
    {
        $this->userAgent = $string;
    }

    /**
     * Get an instance of Auth
     *
     * @return Auth
     */
    public function getAuth() : Auth
    {
        return $this->auth;
    }

    /**
     * Preload OAuth
     *
     * @return  void
     * @throws  APIResponseException
     */
    public function setOAuth() : void
    {
        $oauth = new OAuth;
        $oauth->setEndpoint($this->authParams['endpoint']);

        $response = $oauth->get(
            new HttpClient(),
            $this->getUrl(),
            $this->getAuthParams()
        );

        $this->setCredentials($response);

        $this->setAuth('oauth', [
            'access_token' => $this->credentials->access_token
        ]);
    }

    /**
     * Get Auth Credentials
     * 
     * @return  null|object
     */
    public function getCredentials() :? object
    {
        return $this->credentials;
    }

    /**
     * Set Auth Credentials
     * 
     * @param   object  $credentials
     * 
     * @return  void
     */
    public function setCredentials(object $credentials) :  void
    {
        $this->credentials = $credentials;
    }

    /**
     * Configure the Auth method
     *
     * @param   String  $strategy
     * @param   array   $options
     *
     * @return  void
     * @throws  InvalidAuthenticationStrategyException
     */
    public function setAuth(String $strategy, array $options) : void
    {
        $this->auth = new Auth($strategy, $options);
    }

    /**
     * Set the Auth Parameters manually for username
     * 
     * @param   String  $username
     * 
     * @return  $this
     */
    public function setUsername(String $username)
    {
        $this->authParams['username'] = $username;

        return $this;
    }

    /**
     * Set the Auth Parameters manually for password
     * 
     * @param   String  $password
     * 
     * @return  $this
     */
    public function setPassword(String $password)
    {
        $this->authParams['password'] = $password;

        return $this;
    }

    /**
     * Set the Auth Parameters manually for client ID
     * 
     * @param   String  $clientID
     * 
     * @return  $this
     */
    public function setClientID(String $clientID)
    {
        $this->authParams['client_id'] = $clientID;

        return $this;
    }

    /**
     * Set the Auth Parameters manually for client secret
     * 
     * @param   String  $clientSecret
     * 
     * @return  $this
     */
    public function setClientSecret(String $clientSecret)
    {
        $this->authParams['client_secret'] = $clientSecret;

        return $this;
    }

    /**
     * Set the Auth Parameters manually for oauth url
     * 
     * @param   String  $url
     * 
     * @return  $this
     */
    public function setOAuthAuthEndpoint(String $url)
    {
        $this->authParams['endpoint'] = $url;

        return $this;
    }

    /**
     * Bootstrap the Client dependencies
     * 
     * @return  void
     */
    protected function boot() : void
    {
        $this->guzzle = new HttpClient();
        $this->container = new Container;
    }
}
