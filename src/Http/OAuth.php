<?php

namespace JustSteveKing\SDK\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use JustSteveKing\SDK\Exceptions\APIResponseException;

class OAuth
{
    /**
     * Requests for an access token
     *
     * @param   Client      $client
     * @param   String      $domain
     * @param   array       $params
     *
     * @return  object
     * @throws  APIResponseException
     */
    public static function get(Client $client, String $domain, array $params) : object
    {
        $authUrl = "$domain/oauth/token";

        $params = array_merge([
            'grant_type' => 'password',
            'client_id' => null,
            'client_secret' => null,
            'username' => null,
            'password' => null,
            'scope' => '*'
        ], $params);

        try {
            $request = new Request('POST', $authUrl, ['Content-Type' => 'application/json']);
            $request = $request->withBody(
                \GuzzleHttp\Psr7\stream_for(json_encode($params))
            );

            $response = $client->send($request);
        } catch (RequestException $e) {
            throw new APIResponseException($e);
        }

        return json_decode($response->getBody()->getContents());
    }
}
