<?php

declare(strict_types=1);

namespace Polidog\Esa\Client;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;

final class Authorization
{
    public function __construct(private string $accessToken)
    {
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
