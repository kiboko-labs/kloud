<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Execution\CommandBus;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

final class TaskRunner
{
    private ProcessRegistry $registry;
    private ?Process $current;
    private Task $task;
    private \Iterator $iterator;

    public function __construct(ProcessRegistry $registry, Task $task)
    {
        $this->registry = $registry;
        $this->current = null;
        $this->task = $task;
        $this->iterator = new \NoRewindIterator($task->getIterator());

        $this->iterator->rewind();
    }

    public function next(): void
    {
        if ($this->current !== null) {
            throw new \RuntimeException('A process is already running.');
        }

        if (!$this->iterator->valid()) {
            throw new \RuntimeException('All tasks were consumed.');
        }

        $this->current = $this->iterator->current();
        $this->iterator->next();

        $this->current->start();
    }

    public function isBusy(): bool
    {
        if ($this->current === null) {
            throw new \RuntimeException('No process is running.');
        }

        if (!$this->current->isTerminated()) {
            return true;
        }

        if ($this->current->getExitCode() !== 0) {
            throw new ProcessFailedException($this->current);
        }

        $this->current = null;
        return false;
    }

    public function finished(): bool
    {
        return $this->iterator->valid();
    }
}