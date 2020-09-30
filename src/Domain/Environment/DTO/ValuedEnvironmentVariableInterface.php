<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Environment\DTO;

interface ValuedEnvironmentVariableInterface extends EnvironmentVariableInterface
{
    /** @return int|string|Expression|Variable */
    public function getValue();
}
