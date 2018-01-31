<?php


namespace Polidog\Esa\Client;


use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;

class Authorization
{
    /**
     * @var string
     */
    private $accessToken;

    /**
     * @param string $accessToken
     */
    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @param HandlerStack $stack
     */
    public function push(HandlerStack $stack)
    {
        $stack->push(Middleware::mapRequest([$this, 'handle']));
    }

    /**
     * @param RequestInterface $request
     * @return RequestInterface
     */
    public function handle(RequestInterface $request)
    {
        return $request->withHeader('Authorization', 'Bearer '.$this->accessToken);
    }

}
