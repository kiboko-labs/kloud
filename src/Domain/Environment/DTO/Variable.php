<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Environment\DTO;

class Variable
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
    }
}
