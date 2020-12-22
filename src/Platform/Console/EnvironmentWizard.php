<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;

class EnvironmentWizard
{
    public function configureConsoleCommand(Command $command)
    {
        $command->addOption('working-directory', null, InputOption::VALUE_OPTIONAL, 'Change the working directory in which the kloud environment file will be guessed from and written.');
    }
}
