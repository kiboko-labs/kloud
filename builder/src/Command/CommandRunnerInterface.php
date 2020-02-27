<?php

namespace Builder\Command;

interface CommandRunnerInterface
{
    public function run(CommandBusInterface $commandBus);
}