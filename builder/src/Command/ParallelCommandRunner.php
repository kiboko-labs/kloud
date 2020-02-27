<?php declare(strict_types=1);

namespace Builder\Command;

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

    public function run(CommandBusInterface $commandBus)
    {
        $iterator = new \RecursiveIteratorIterator($commandBus, \RecursiveIteratorIterator::SELF_FIRST);

        /** @var ConsoleSectionOutput $section */
        $progressBar = new ProgressBar($this->output->section(), iterator_count($iterator));
        $section = $this->output->section();

        // do not modify the object pointers in the argument, copy to local working variable
        $processes = new \SplObjectStorage();
        $processesQueue = array_map(function (CommandInterface $command) use ($processes): Process {
            $process = $command();
            $processes[$process] = $command;
            return $process;
        }, iterator_to_array($iterator));

        // fix maxParallel to be max the number of processes or positive
        $maxParallel = min(abs($this->maxProcesses), count($processesQueue));

        // get the first stack of processes to start at the same time
        /** @var Process[] $currentProcesses */
        $currentProcesses = array_splice($processesQueue, 0, $maxParallel);

        $sections = new \SplObjectStorage();
        // start the initial stack of processes
        foreach ($currentProcesses as $index => $process) {
            $process->start();
            /** @var ConsoleSectionOutput $section */
            $section = $sections[$process] = $this->output->section();
            $section->overwrite(sprintf('Running: <info>%s</>', (string) $processes[$process]));
        }

        do {
            // wait for the given time
            usleep($this->poll);

            // remove all finished processes from the stack
            foreach ($currentProcesses as $index => $process) {
                if (!$process->isRunning()) {
                    $progressBar->advance();
                    /** @var ConsoleSectionOutput $section */
                    $section = $sections[$process];
                    unset($sections[$process]);
                    unset($currentProcesses[$index]);

                    // directly add and start new process after the previous finished
                    if (count($processesQueue) > 0) {
                        $nextProcess = array_shift($processesQueue);
                        $nextProcess->start(/*function ($type, $buffer) use ($callback, $nextProcess) {
                            if (null !== $callback && is_callable($callback)) {
                                $callback($type, $buffer, $nextProcess);
                            }
                        }*/);
                        $sections[$nextProcess] = $section;
                        $currentProcesses[] = $nextProcess;
                        $section->overwrite(sprintf('Running: <info>%s</>', (string) $processes[$nextProcess]));
                    } else {
                        $section->overwrite('Finished!');
                    }
                }
            }
            // continue loop while there are processes being executed or waiting for execution
        } while (count($processesQueue) > 0 || count($currentProcesses) > 0);
    }
}