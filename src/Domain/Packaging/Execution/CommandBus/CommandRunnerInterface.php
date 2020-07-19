<?php

namespace Kiboko\Cloud\Domain\Packaging\Execution\CommandBus;

interface CommandRunnerInterface
{
    public function run(CommandBusInterface $commandBus, string $rootPath);
}
