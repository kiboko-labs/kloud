<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\Compose;

interface ValuedEnvironmentVariableInterface extends EnvironmentVariableInterface
{
    public function getValue();
}