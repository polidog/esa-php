<?php


namespace Polidog\Esa\Test\Client;


use GuzzleHttp\HandlerStack;
use PHPUnit\Framework\TestCase;
use Polidog\Esa\Client\Authorization;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;

class AuthorizationTest extends TestCase
{
    public function testHandle()
    {
        $request = $this->prophesize(RequestInterface::class);

        $authorization = new Authorization('token');
        $authorization->handle($request->reveal());

        $request->withHeader('Authorization', 'Bearer token')
            ->shouldHaveBeenCalled();
    }

    public function testPush()
    {
        $handlerStack = $this->prophesize(HandlerStack::class);

        $authorization = new Authorization('token');
        $authorization->push($handlerStack->reveal());

        $handlerStack->push(Argument::any())
            ->shouldHaveBeenCalled();
    }
}
