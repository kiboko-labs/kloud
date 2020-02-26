<?php declare(strict_types=1);

namespace Builder\Command;

interface CommandCompositeInterface extends CommandInterface, \Traversable, \Countable
{
    public function add(CommandInterface ...$command): void;
}