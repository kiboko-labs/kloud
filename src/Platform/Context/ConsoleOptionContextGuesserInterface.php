<?php declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Context;

use Symfony\Component\Console\Command\Command;

interface ConsoleOptionContextGuesserInterface extends ContextGuesserInterface
{
    public function configure(Command $command);
}