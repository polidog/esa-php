<?php

namespace Polidog\Esa;

use GuzzleHttp\ClientInterface as HttpClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Polidog\Esa\Exception\ApiErrorException;
use Psr\Http\Message\RequestInterface;

final class Client
{
    private $accessToken;

    private $currentTeam;

    private $httpClient;

    private $apiMethods;

    /**
     * @var array
     */
    private $httpOptions = [
        'base_uri' => 'https://api.esa.io/v1/',
        'timeout' => 60,
        'allow_redirect' => false,
        'headers' => [
            'User-Agent' => 'esa-php-api v1',
            'Accept' => 'application/json',
        ],
    ];

    /**
     * @param $accessToken
     * @param $currentTeam
     * @param HttpClientInterface $httpClient
     * @param array               $httpOptions
     */
    public function __construct($accessToken, $currentTeam, HttpClientInterface $httpClient = null, $httpOptions = [])
    {
        $this->accessToken = $accessToken;
        $this->currentTeam = $currentTeam;
        $this->httpOptions = array_merge($this->httpOptions, $httpOptions);
        $this->httpOptions['handler'] = $this->createAuthStack();

        if (empty($httpClient)) {
            $httpClient = new \GuzzleHttp\Client($this->httpOptions);
        }
        $this->httpClient = $httpClient;
        $this->apiMethods = new ApiMethods($httpClient, $currentTeam);
    }

    /**
     * @param $name
     * @param $args
     * @return mixed
     *
     * @throws ApiErrorException
     */
    public function __call($name, $args)
    {
        try {
            /** @var Response $response */
            $response = call_user_func_array([$this->apiMethods, $name], $args);
            $data = json_decode($response->getBody()->getContents(), true);
            return $data;
        } catch (\Exception $exception) {
            throw ApiErrorException::newException($exception, $name, $args);
        }
    }

    private function createAuthStack()
    {
        $stack = HandlerStack::create();
        $stack->push(Middleware::mapRequest(function (RequestInterface $request) {
            return $request->withHeader('Authorization', 'Bearer '.$this->accessToken);
        }));

        return $stack;
    }
}
