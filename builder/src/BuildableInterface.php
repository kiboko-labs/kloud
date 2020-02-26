<?php declare(strict_types=1);

namespace Builder;

use Builder\Command;

/**
 * @property-read string $path
 */
interface BuildableInterface
{
    public function pull(Command\CommandCompositeInterface $commands): void;
    public function push(Command\CommandCompositeInterface $commands): void;
    public function build(Command\CommandCompositeInterface $commands): void;
}