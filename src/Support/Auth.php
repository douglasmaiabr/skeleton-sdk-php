<?php

namespace JustSteveKing\SDK\Support;

use JustSteveKing\SDK\Exceptions\Auth\InvalidAuthenticationStrategyException;

class Auth
{
    /**
     * The authentication setting to use when OAuth is chosen
     */
    const OAUTH = 'oauth';

    /**
     * The authentication setting to use when Basic is chosen
     */
    const BASIC = 'basic';

    /**
     * @var String
     */
    protected $authStrategy;

    /**
     * @var array
     */
    protected $authOptions;

    /**
     * Set the Auth Options
     * 
     * @param   array  $authOptions
     * 
     * @return  void
     */
    public function setAuthOptions(array $authOptions) : void
    {
        $this->authOptions = $authOptions;
    }

    /**
     * Get the Auth Options
     * 
     * @return  array
     */
    public function getAuthOptions() : array
    {
        return $this->authOptions;
    }

    /**
     * Set the Auth Strategy
     * 
     * @param   String  $authStrategy
     * 
     * @return  void
     * @throws  InvalidAuthenticationStrategyException
     */
    public function setAuthStrategy(String $authStrategy) : void
    {
        if (! in_array($authStrategy, self::getValidAuthStrategies())) {
            throw new InvalidAuthenticationStrategyException('Invalid auth strategy set');
        }

        $this->authStrategy = $authStrategy;
    }

    /**
     * Get the Auth Strategy
     * 
     * @return  String
     */
    public function getAuthStrategy() : String
    {
        return $this->authStrategy;
    }

    /**
     * Returns an array containing the valid auth strategies
     *
     * @return array
     */
    protected static function getValidAuthStrategies() : array
    {
        return [
            self::BASIC,
            self::OAUTH
        ];
    }
}
