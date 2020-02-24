<?php declare(strict_types=1);

namespace Builder\Command;

final class CommandQueue implements CommandInterface
{
    private array $commands;

    public function __construct(CommandInterface ...$commands)
    {
        $this->commands = $commands;
    }

    public function add(CommandInterface ...$commands)
    {
        $this->commands = $commands;
    }

    public function __invoke(): void
    {
        foreach ($this->commands as $command) {
            $command();
        }
    }
}