<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging;

final class Repository implements \Stringable, RepositoryInterface
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
    }
}
