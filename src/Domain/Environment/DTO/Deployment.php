<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Environment\DTO;

class Deployment
{
    public Server $server;
    public string $path;

    public function __construct(?Server $server = null, ?string $path = null)
    {
        $this->server = $server;
        $this->path = $path;
    }
}
