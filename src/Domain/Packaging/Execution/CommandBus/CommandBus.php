<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Execution\CommandBus;

use Kiboko\Cloud\Domain\Packaging;

final class CommandBus implements CommandBusInterface, \Iterator
{
    private \Iterator $tasks;

    public function __construct(Packaging\Execution\Command\CommandInterface ...$commands)
    {
        $this->tasks = new \ArrayIterator([new Task(...$commands)]);
    }

    public function __toString()
    {
        return sprintf('command bus( %d )', count($this));
    }

    public function task(): Task
    {
        $this->tasks->append($task = new Task());

        return $task;
    }

    public function add(Packaging\Execution\Command\CommandInterface ...$commands): Task
    {
        $this->tasks->append($task = new Task(...$commands));

        return $task;
    }

    public function countProcesses(): int
    {
        $sum = 0;
        foreach ($this->tasks as $task) {
            $sum += count($task);
        }
        return $sum;
    }

    public function count()
    {
        return count($this->tasks);
    }

    public function current()
    {
        return $this->tasks->current();
    }

    public function next()
    {
        $this->tasks->next();
    }

    public function key()
    {
        return $this->tasks->key();
    }

    public function valid()
    {
        return $this->tasks->valid();
    }

    public function rewind()
    {
        $this->tasks->rewind();
    }
}
