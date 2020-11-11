<?php

declare(strict_types=1);

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

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @throws ClientException
     * @throws \RuntimeException
     */
    public function request(string $method, string $path, array $data = []): array
    {
        try {
            $response = $this->httpClient->request($method, $path, $data);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw ClientException::newException($e, $method, $path, $data);
        }
    }

    public static function factory(string $accessToken, array $httpOptions = []): self
    {
        $httpOptions = array_merge(static::$httpOptions, $httpOptions);
        $authorization = new Authorization($accessToken);

        $httpOptions['handler'] = HandlerStack::create();
        $authorization->push($httpOptions['handler']);

        return new self(new \GuzzleHttp\Client($httpOptions));
    }
}
