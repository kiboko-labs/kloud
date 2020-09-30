<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Environment\DTO;

interface EnvironmentVariableInterface
{
    public function getVariable(): Variable;
}
