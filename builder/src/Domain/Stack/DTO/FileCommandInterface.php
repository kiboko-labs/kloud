<?php

namespace Builder\Domain\Stack\DTO;

interface FileCommandInterface
{
    public function saveTo(string $path): void;
}