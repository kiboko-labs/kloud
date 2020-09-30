<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Environment\DTO;

class Server
{
    public string $hostname;
    public int $port;
    public string $username;

    public function __construct(string $hostname, int $port, string $username)
    {
        $this->hostname = $hostname;
        $this->port = $port;
        $this->username = $username;
    }
}
