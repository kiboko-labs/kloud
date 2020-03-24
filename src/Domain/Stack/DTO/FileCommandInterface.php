<?php

namespace Kiboko\Cloud\Domain\Stack\DTO;

interface FileCommandInterface
{
    public function saveTo(string $path): void;
}