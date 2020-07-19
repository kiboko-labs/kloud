<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging;

use Kiboko\Cloud\Domain\Packaging;

interface BuildableInterface
{
    public function pull(Packaging\Execution\CommandBus\Task $task): Packaging\Execution\CommandBus\Task;
    public function push(Packaging\Execution\CommandBus\Task $task): Packaging\Execution\CommandBus\Task;
    public function build(Packaging\Execution\CommandBus\Task $task): Packaging\Execution\CommandBus\Task;
    public function forceBuild(Packaging\Execution\CommandBus\Task $task): Packaging\Execution\CommandBus\Task;
}
