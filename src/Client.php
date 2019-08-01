<?php

namespace JustSteveKing\SDK;

use League\Container\Container;
use GuzzleHttp\Client as HttpClient;

class Client
{
    /**
     * @var String
     */
    protected $url;

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
