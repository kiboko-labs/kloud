<?php declare(strict_types=1);

namespace Builder;

interface BuildableContextInterface extends ContextInterface
{
    public function getPath(): Placeholder;
}