<?php
namespace Polidog\Esa;

use Phake;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function callApi()
    {
        $httpClient = Phake::mock("GuzzleHttp\\Client");


        $response = Phake::mock("Psr\\Http\\Message\\ResponseInterface");
        $stream = Phake::Mock("Psr\\Http\\Message\\StreamInterface");

        Phake::when($httpClient)->request("GET","teams")
            ->thenReturn($response);

        Phake::when($response)->getStatusCode()
            ->thenReturn(200);

        Phake::when($response)->getBody()
            ->thenReturn($stream);

        $client = new Client("token",'polidog', $httpClient);
        $client->teams();

        Phake::verify($response)->getStatusCode();
        Phake::verify($response)->getBody();
        Phake::verify($stream)->getContents();

    }

}