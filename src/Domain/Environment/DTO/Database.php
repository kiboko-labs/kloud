<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Environment\DTO;

class Database
{
    public ?string $databaseName;
    public ?string $username;
    public ?string $password;

    public function __construct(?string $databaseName = null, ?string $username = null, ?string $password = null)
    {
        $this->databaseName = $databaseName;
        $this->username = $username;
        $this->password = $password;
    }
}
