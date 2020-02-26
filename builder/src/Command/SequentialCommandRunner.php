<?php declare(strict_types=1);

namespace Builder\Command;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;
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

        /** @var ConsoleSectionOutput $section */
        $progressBar = new ProgressBar($this->output->section(), iterator_count($iterator));
        $section = $this->output->section();

        /** @var CommandInterface $command */
        foreach ($progressBar->iterate($iterator) as $command) {
            $section->overwrite(sprintf('Running: <info>%s</>', (string) $command));
            $command();
        }
    }
}