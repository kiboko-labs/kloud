<?php declare(strict_types=1);

namespace Builder\Domain\Stack\Compose;

interface ValuedEnvironmentVariableInterface extends EnvironmentVariableInterface
{
    public function getValue();
}