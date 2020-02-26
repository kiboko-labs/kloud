<?php declare(strict_types=1);

namespace Builder;

interface BuildableTagInterface extends TagInterface, BuildableInterface
{
    public function getPath(): string;
}