<?php


namespace Polidog\Esa\Client;


interface ClientInterface
{
    /**
     * @param string $method
     * @param string $path
     * @param array $data
     * @return array
     */
    public function request($method, $path, array $data = []);
}
