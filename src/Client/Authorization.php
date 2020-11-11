<?php

declare(strict_types=1);

namespace Polidog\Esa\Client;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;

class Authorization
{
    /**
     * @var string
     */
    private $accessToken;

    public function __construct(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function push(HandlerStack $stack): void
    {
        $stack->push(Middleware::mapRequest([$this, 'handle']));
    }

    public function handle(RequestInterface $request): MessageInterface
    {
        return $request->withHeader('Authorization', 'Bearer '.$this->accessToken);
    }
}
