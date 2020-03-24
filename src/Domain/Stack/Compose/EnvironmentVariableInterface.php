<?php

namespace Kiboko\Cloud\Domain\Stack\Compose;

interface EnvironmentVariableInterface
{
    public function getVariable(): Variable;
}