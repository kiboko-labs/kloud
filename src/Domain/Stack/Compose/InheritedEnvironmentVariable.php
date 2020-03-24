<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\Compose;

final class InheritedEnvironmentVariable implements EnvironmentVariableInterface
{
    private Variable $variable;

    public function __construct(Variable $variable)
    {
        $this->variable = $variable;
    }

    public function __toString()
    {
        return $this->variable->name;
    }

    public function getVariable(): Variable
    {
        return $this->variable;
    }
}