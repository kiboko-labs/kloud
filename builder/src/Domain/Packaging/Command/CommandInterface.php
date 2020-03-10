<?php

declare(strict_types=1);

namespace Builder\Domain\Packaging\Command;

use Symfony\Component\Process\Process;

interface CommandInterface
{
    public function __toString();

    public function __invoke(): Process;
}
