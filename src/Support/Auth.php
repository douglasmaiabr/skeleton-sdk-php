<?php

namespace JustSteveKing\SDK\Support;

use JustSteveKing\SDK\Exceptions\Auth\CredentialsException;
use JustSteveKing\SDK\Exceptions\Auth\AuthenticationException;
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
     * Create a new instance of Auth
     * 
     * @return  void
     * @throws  InvalidAuthenticationStrategyException
     * @throws  AuthenticationException
     * @throws  CredentialsException
     */
    public function __construct(String $strategy, array $options)
    {
        if (! in_array($strategy, self::getValidAuthStrategies())) {
            throw new InvalidAuthenticationStrategyException('Invalid auth strategy set');
        }

        $this->setAuthStrategy($strategy);

        if ($strategy === self::BASIC) {
            if (! array_key_exists('username', $options) || ! array_key_exists('token', $options)) {
                throw new CredentialsException('Please supply `username` and `password` for basic auth.');
            }
        } elseif ($strategy === self::OAUTH) {
            if (! array_key_exists('access_token', $options)) {
                throw new AuthenticationException('Please supply `access_token` for oauth.');
            }
        }

        $this->setAuthOptions($options);
    }

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
     * Prepare our request for sending
     *
     * @param   RequestInterface    $request
     * @param   array               $requestOptions
     *
     * @return  array
     * @throws  AuthenticationException
     */
    public function prepareRequest(RequestInterface $request, array $requestOptions = []) : array
    {
        if ($this->authStrategy === self::BASIC) {
            $user = $this->authOptions['username'];
            $password = $this->authOptions['password'];
            $token = base64_encode("{$user}:{$password}");
            $request = $request->withAddedHeader(
                'Authorization',
                "Basic {$token}"
            );
        } elseif ($this->authStrategy === self::OAUTH) {
            $token = $this->authOptions['access_token'];
            $request = $request->withAddedHeader(
                'Authorization',
                "Bearer {$token}"
            );
        } else {
            throw new AuthenticationException('Please set authentication to send requests.');
        }

        return [
            $request,
            $requestOptions
        ];
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
