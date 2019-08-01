<?php

namespace JustSteveKing\SDK;

class Client
{
    /**
     * @var String
     */
    protected $url;

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
}
