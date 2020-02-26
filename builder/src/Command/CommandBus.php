<?php declare(strict_types=1);

namespace Builder\Command;

final class CommandBus implements CommandCompositeInterface, \Iterator, \RecursiveIterator
{
    private array $commands;
    private \Iterator $iterator;

    public function __construct(CommandInterface ...$commands)
    {
        $this->commands = $commands;
        $this->iterator = new \ArrayIterator($this->commands);
    }

    public function __toString()
    {
        return sprintf('commandBus(%d)', count($this));
    }

    public function add(CommandInterface ...$commands): void
    {
        array_push($this->commands, ...$commands);
        $this->iterator = new \ArrayIterator($this->commands);
    }

    public function __invoke(): void
    {
        foreach ($this->commands as $command) {
            $command();
        }
    }

    public function count()
    {
        return count($this->commands);
    }

    public function current()
    {
        return $this->iterator->current();
    }

    public function next()
    {
        $this->iterator->next();
    }

    public function key()
    {
        return $this->iterator->key();
    }

    public function valid()
    {
        return $this->iterator->valid();
    }

    public function rewind()
    {
        $this->iterator->rewind();
    }

    public function hasChildren()
    {
        return $this->iterator->current() instanceof CommandCompositeInterface;
    }

    public function getChildren()
    {
        if ($this->iterator->current() instanceof CommandCompositeInterface) {
            return $this->iterator->current();
        }

        return new \RecursiveArrayIterator([]);
    }
}