<?php declare(strict_types=1);

namespace Builder\Command;

interface CommandBusInterface extends \Traversable, \Countable
{
    public function __toString();
    public function __invoke(): void;
    public function add(CommandInterface ...$command): void;
}