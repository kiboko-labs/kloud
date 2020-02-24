<?php declare(strict_types=1);

namespace Builder\Package;

final class Repository implements RepositoryInterface
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