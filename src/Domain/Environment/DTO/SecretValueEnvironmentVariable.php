<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Environment\DTO;

class SecretValueEnvironmentVariable implements EnvironmentVariableInterface
{
    private Variable $variable;
    private string $secret;

    public function __construct(Variable $variable, string $secret)
    {
        $this->variable = $variable;
        $this->secret = $secret;
    }

    public function getVariable(): Variable
    {
        return $this->variable;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }

    public function setSecret(string $secret)
    {
        $this->secret = $secret;
    }
}
