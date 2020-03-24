<?php

namespace Builder\Domain\Packaging\CommandBus;

interface CommandRunnerInterface
{
    public function run(CommandBusInterface $commandBus);
}
