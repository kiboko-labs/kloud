<?php

namespace Builder\Domain\Stack\Compose;

interface EnvironmentVariableInterface
{
    public function getVariable(): Variable;
}