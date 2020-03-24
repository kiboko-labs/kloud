<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Context;

use Kiboko\Cloud\Domain\Packaging\Placeholder;

interface BuildableContextInterface extends ContextInterface
{
    public function getPath(): Placeholder;
}
