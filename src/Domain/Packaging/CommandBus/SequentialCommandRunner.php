<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\CommandBus;

use Kiboko\Cloud\Domain\Packaging;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;

final class SequentialCommandRunner implements CommandRunnerInterface
{
    private InputInterface $input;
    private OutputInterface $output;

    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
    }

    public function run(CommandBusInterface $commandBus)
    {
        $iterator = new \RecursiveIteratorIterator($commandBus, \RecursiveIteratorIterator::SELF_FIRST);

        /** @var ConsoleSectionOutput $section */
        $progressBar = new ProgressBar($this->output->section());
        $section = $this->output->section();

        /** @var Packaging\Command\CommandInterface $command */
        foreach ($progressBar->iterate($iterator, iterator_count($iterator)) as $command) {
            $section->overwrite(sprintf('Running: <info>%s</>', (string) $command));
            $process = $command();

            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
        }
        $section->overwrite('Finished!');
    }
}
