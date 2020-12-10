<?php declare(strict_types=1);

namespace test\Kiboko\Cloud;

use Kiboko\Cloud\Domain\Packaging\Execution\Command\CommandInterface;
use Kiboko\Cloud\Domain\Packaging\Execution\CommandBus\CommandBusInterface;
use Kiboko\Cloud\Domain\Packaging\Execution\CommandBus\CommandRunnerInterface;
use Kiboko\Cloud\Domain\Packaging\Execution\CommandBus\Task;
use Symfony\Component\Process\Process;

final class TestCommandRunner implements CommandRunnerInterface, \IteratorAggregate
{
    private iterable $processes;

    public function __construct()
    {
        $this->processes = [];
    }

    public function run(CommandBusInterface $commandBus, string $rootPath)
    {
        /** @var Task $task */
        foreach ($commandBus as $task) {
            /** @var CommandInterface $command */
            foreach ($task as $command) {
                $process = $command($rootPath);

                $this->execute($process);
            }
        }
    }

    private function execute(Process $process): void
    {
        $this->processes[$process->getCommandLine()] = $process;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->processes);
    }
}
