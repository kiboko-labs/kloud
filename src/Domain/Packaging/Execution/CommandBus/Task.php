<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Execution\CommandBus;

use Kiboko\Cloud\Domain\Packaging\Execution\Command\CommandInterface;

final class Task implements \IteratorAggregate, \Countable
{
    private iterable $commands;

    public function __construct(CommandInterface ...$commands)
    {
        $this->commands = $commands;
    }

    public function then(CommandInterface ...$commands): self
    {
        array_push($this->commands, ...$commands);

        return $this;
    }

    public function getIterator()
    {
        yield from $this->commands;
    }

    public function count()
    {
        return count($this->commands);
    }

    public function __toString()
    {
        return implode(', ', array_map(function (CommandInterface $command): string {
            return (string) $command;
        }, $this->commands));
    }
}