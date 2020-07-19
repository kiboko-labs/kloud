<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Execution\Command;

use Symfony\Component\Process\Process;

interface CommandInterface extends \Stringable
{
    public function __invoke(string $rootPath): Process;
}
