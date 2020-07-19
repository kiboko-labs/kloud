<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Execution\CommandBus;

use Kiboko\Cloud\Domain\Packaging;

interface CommandBusInterface extends \Traversable, \Countable, \Stringable
{
    public function add(Packaging\Execution\Command\CommandInterface ...$command): Task;

    public function countProcesses(): int;
}
