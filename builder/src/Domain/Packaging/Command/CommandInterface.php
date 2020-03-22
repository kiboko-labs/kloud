<?php

declare(strict_types=1);

namespace Builder\Domain\Packaging\Command;

use Symfony\Component\Process\Process;

interface CommandInterface extends \Stringable
{
    public function __invoke(): Process;
}
