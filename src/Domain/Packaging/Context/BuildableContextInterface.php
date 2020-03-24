<?php

declare(strict_types=1);

namespace Builder\Domain\Packaging\Context;

use Builder\Domain\Packaging\Placeholder;

interface BuildableContextInterface extends ContextInterface
{
    public function getPath(): Placeholder;
}
