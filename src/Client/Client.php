<?php

namespace Polidog\Esa\Client;

use GuzzleHttp\ClientInterface as HttpClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Polidog\Esa\Exception\ApiErrorException;
use Psr\Http\Message\RequestInterface;

final class Client implements ClientInterface
{
    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var array
     */
    private static $httpOptions = [
        'base_uri' => 'https://api.esa.io/v1/',
        'timeout' => 60,
        'allow_redirect' => false,
        'headers' => [
            'User-Agent' => 'esa-php-api v2',
            'Accept' => 'application/json',
        ],
    ];

    /**
     * @param string              $accessToken
     * @param HttpClientInterface $httpClient
     */
    public function __construct($accessToken, HttpClientInterface $httpClient)
    {
        $this->accessToken = $accessToken;
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $method
     * @param string $path
     * @param array  $data
     *
     * @return array
     *
     * @throws ApiErrorException
     */
    public function request($method, $path, array $data = [])
    {
        try {
            $response = $this->httpClient->request($method, $path, $data);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw ApiErrorException::newException($e, $path, $data);
        }
    }

    public static function factory($accessToken, $httpOptions = [])
    {
        $httpOptions = array_merge(static::$httpOptions, $httpOptions);
        $httpOptions['handler'] = static::createAuthStack($accessToken);

        return new self($accessToken, new \GuzzleHttp\Client($httpOptions));
    }

    private static function createAuthStack($accessToken)
    {
        $stack = HandlerStack::create();
        $stack->push(Middleware::mapRequest(function (RequestInterface $request) use ($accessToken) {
            return $request->withHeader('Authorization', 'Bearer '.$accessToken);
        }));

        return $stack;
    }
}
