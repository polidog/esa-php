<?php

declare(strict_types=1);

namespace Polidog\Esa\Client;

interface ClientInterface
{
    public function request(string $method, string $path, array $data = []): array;
}
