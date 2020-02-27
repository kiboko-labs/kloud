<?php declare(strict_types=1);

namespace Builder;

use Builder\Command;

/**
 * @property-read string $path
 */
interface BuildableInterface
{
    public function pull(Command\CommandBusInterface $commands): void;
    public function push(Command\CommandBusInterface $commands): void;
    public function build(Command\CommandBusInterface $commands): void;
    public function forceBuild(Command\CommandBusInterface $commands): void;
}