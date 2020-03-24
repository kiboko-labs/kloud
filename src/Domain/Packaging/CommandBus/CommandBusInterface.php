<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\CommandBus;

use Kiboko\Cloud\Domain\Packaging;

interface CommandBusInterface extends \Traversable, \Countable, \Stringable
{
    public function __invoke(): void;

    public function add(Packaging\Command\CommandInterface ...$command): void;
}
