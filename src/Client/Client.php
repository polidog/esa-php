<?php

namespace Polidog\Esa\Client;

use GuzzleHttp\ClientInterface as HttpClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use Polidog\Esa\Exception\ClientException;

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
     * @throws ClientException
     * @throws \RuntimeException
     */
    public function request($method, $path, array $data = [])
    {
        try {
            $response = $this->httpClient->request($method, $path, $data);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw ClientException::newException($e, $method, $path, $data);
        }
    }

    /**
     * @param       $accessToken
     * @param array $httpOptions
     *
     * @return Client
     */
    public static function factory($accessToken, $httpOptions = [])
    {
        $httpOptions = array_merge(static::$httpOptions, $httpOptions);
        $authorization = new Authorization($accessToken);

        $httpOptions['handler'] = HandlerStack::create();
        $authorization->push($httpOptions['handler']);

        return new self($accessToken, new \GuzzleHttp\Client($httpOptions));
    }

}
