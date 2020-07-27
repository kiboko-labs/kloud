<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Execution\CommandBus;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

/**
 * @see https://github.com/jagandecapri/symfony-parallel-process
 */
final class ParallelCommandRunner implements CommandRunnerInterface
{
    private InputInterface $input;
    private OutputInterface $output;
    private int $maxProcesses;
    private int $poll;

    public function __construct(InputInterface $input, OutputInterface $output, int $maxProcesses = 10, int $poll = 1000)
    {
        $this->input = $input;
        $this->output = $output;
        $this->maxProcesses = $maxProcesses;
        $this->poll = $poll;
    }

    public function run(CommandBusInterface $commandBus, string $rootPath)
    {
        /** @var ConsoleSectionOutput $section */
        $progressBar = new ProgressBar($this->output->section(), count($commandBus));

        $queue = new TaskQueue($commandBus, min(abs($this->maxProcesses), $commandBus->countProcesses()));

        $queue->start();
        do {
            // wait for the given time
            usleep($this->poll);

            $queue->poll(function () use ($progressBar) {
                $progressBar->advance();
            });
        } while ($queue->finished());
    }
}
