<?php

namespace Polidog\Esa\Test\Client;

use GuzzleHttp\Exception\TransferException;
use PHPUnit\Framework\TestCase;
use Polidog\Esa\Client\Client;
use GuzzleHttp\ClientInterface as HttpClientInterface;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ClientTest extends TestCase
{
    public function testFactory()
    {
        $client = Client::factory('token');
        $this->assertInstanceOf(Client::class, $client);
    }

    public function testRequest()
    {
        $httpClient = $this->prophesize(HttpClientInterface::class);
        $response = $this->prophesize(ResponseInterface::class);
        $stream = $this->prophesize(StreamInterface::class);

        $stream->getContents()
            ->willReturn(json_encode(['a' => 'b']));

        $response->getBody()
            ->willReturn($stream->reveal());

        $httpClient->request(Argument::any(), Argument::any(), Argument::any())
            ->willReturn($response->reveal());

        $client = new Client('token', $httpClient->reveal());
        $client->request('GET', '/test', ['query' => ['a' => 'b']]);
        $httpClient->request('GET', '/test', ['query' => ['a' => 'b']]);
    }

    /**
     * @expectedException  \Polidog\Esa\Exception\ApiErrorException
     */
    public function testRequestException()
    {
        $httpClient = $this->prophesize(HttpClientInterface::class);
        $httpClient->request('GET', '/test', ['query' => ['a' => 'b']])->willThrow(
            new TransferException()
        );
        $client = new Client('token', $httpClient->reveal());
        $client->request('GET', '/test', ['query' => ['a' => 'b']]);
    }
}
