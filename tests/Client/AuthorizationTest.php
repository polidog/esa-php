<?php

declare(strict_types=1);

namespace Polidog\Esa\Test\Client;

use GuzzleHttp\HandlerStack;
use PHPUnit\Framework\TestCase;
use Polidog\Esa\Client\Authorization;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;

final class AuthorizationTest extends TestCase
{
    use ProphecyTrait;

    public function testHandle(): void
    {
        $token = 'xxxxxxxxxxxxxxxxxx';
        $request = $this->prophesize(RequestInterface::class);
        $message = $this->prophesize(MessageInterface::class);

        $request->withHeader('Authorization', 'Bearer '.$token)->willReturn($message);

        $authorization = new Authorization($token);
        $authorization->handle($request->reveal());

        $request->withHeader('Authorization', 'Bearer '.$token)
            ->shouldHaveBeenCalled();
    }

    public function testPush(): void
    {
        $handlerStack = $this->prophesize(HandlerStack::class);

        $authorization = new Authorization('token');
        $authorization->push($handlerStack->reveal());

        $handlerStack->push(Argument::any())
            ->shouldHaveBeenCalled();
    }
}
