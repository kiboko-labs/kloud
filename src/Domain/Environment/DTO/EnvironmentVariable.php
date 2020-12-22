<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Environment\DTO;

class EnvironmentVariable implements EnvironmentVariableInterface
{
    private Variable $variable;

    public function __construct(Variable $variable)
    {
        $this->variable = $variable;
    }

    public function getVariable(): Variable
    {
        return $this->variable;
    }
}
