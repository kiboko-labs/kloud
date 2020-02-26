<?php declare(strict_types=1);

namespace Builder\Command;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

final class SequentialCommandRunner implements CommandRunnerInterface
{
    private InputInterface $input;
    private OutputInterface $output;

    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
    }

    public function run(CommandCompositeInterface $commandBus)
    {
        $iterator = new \RecursiveIteratorIterator($commandBus, \RecursiveIteratorIterator::SELF_FIRST);

        $progressBar = new ProgressBar($this->output, iterator_count($iterator));

        /** @var CommandInterface $command */
        foreach ($progressBar->iterate($iterator) as $command) {
            $this->output->writeln(sprintf('Running: <info>%s</>', (string) $command));
            $command();
        }
    }
}