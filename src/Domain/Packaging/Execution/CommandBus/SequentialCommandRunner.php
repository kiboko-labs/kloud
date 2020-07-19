<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Execution\CommandBus;

use Kiboko\Cloud\Domain\Packaging\Execution\Command\CommandInterface;
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

    public function run(CommandBusInterface $commandBus, string $rootPath)
    {
        /** @var ConsoleSectionOutput $section */
        $progressBar = new ProgressBar($this->output->section());
        $section = $this->output->section();

        /** @var Task $task */
        foreach ($progressBar->iterate($commandBus, count($commandBus)) as $task) {
            /** @var CommandInterface $command */
            foreach ($task as $command) {
                $section->overwrite(sprintf('Running: <info>%s</>', (string)$task));
                $process = $command($rootPath);

                $process->run();

                if (!$process->isSuccessful()) {
                    throw new ProcessFailedException($process);
                }
            }
        }
        $section->overwrite('Finished!');
    }
}
