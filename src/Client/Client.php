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

    public function __construct(private HttpClientInterface $httpClient)
    {
    }

    /**
     * @throws ClientException
     * @throws \RuntimeException
     * @throws \JsonException
     */
    public function request(string $method, string $path, array $data = []): array
    {
        try {
            $response = $this->httpClient->request($method, $path, $data);

            return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        } catch (GuzzleException $e) {
            throw ClientException::newException($e, $method, $path, $data);
        }
    }

    public static function factory(string $accessToken, array $httpOptions = []): self
    {
        $httpOptions = array_merge(self::$httpOptions, $httpOptions);
        $authorization = new Authorization($accessToken);

        $httpOptions['handler'] = HandlerStack::create();
        $authorization->push($httpOptions['handler']);

        return new self(new \GuzzleHttp\Client($httpOptions));
    }
}
