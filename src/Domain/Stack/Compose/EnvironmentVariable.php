<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\Compose;

final class EnvironmentVariable implements \Stringable, ValuedEnvironmentVariableInterface
{
    private Variable $variable;
    /** @var string|int|Variable|Expression */
    private $value;

    public function __construct(Variable $variable, $value = null)
    {
        $this->variable = $variable;
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->variable->name;
    }

    public function getVariable(): Variable
    {
        return $this->variable;
    }

    public function getValue()
    {
        return $this->value;
    }
}