<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Environment\DTO;

class DirectValueEnvironmentVariable implements ValuedEnvironmentVariableInterface
{
    private Variable $variable;
    /** @var int|string|Variable|Expression */
    private $value;

    public function __construct(Variable $variable, $value)
    {
        $this->variable = $variable;
        $this->value = $value;
    }

    public function getVariable(): Variable
    {
        return $this->variable;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue(string $value)
    {
        $this->value = $value;
    }
}
