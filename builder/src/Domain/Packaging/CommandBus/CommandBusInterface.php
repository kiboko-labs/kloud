<?php

declare(strict_types=1);

namespace Builder\Domain\Packaging\CommandBus;

use Builder\Domain\Packaging;

interface CommandBusInterface extends \Traversable, \Countable
{
    public function __toString();

    public function __invoke(): void;

    public function add(Packaging\Command\CommandInterface ...$command): void;
}
