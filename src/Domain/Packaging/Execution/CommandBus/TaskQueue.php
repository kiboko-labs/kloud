<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Execution\CommandBus;

use Symfony\Component\Process\Process;

final class TaskQueue
{
    /** @var \SplQueue|TaskRunner[] */
    private \SplQueue $taskQueue;
    /** @var TaskRunner[] */
    private iterable $currentTasks;
    private ProcessRegistry $processRegistry;
    private int $maxParallelism;

    public function __construct(CommandBusInterface $commandBus, int $maxParallelism = 10)
    {
        $this->taskQueue = new \SplQueue();
        $this->processRegistry = new ProcessRegistry();
        $this->maxParallelism = $maxParallelism;
        $this->currentTasks = [];

        foreach ($commandBus as $task) {
            $this->taskQueue->enqueue(new TaskRunner($this->processRegistry, $task));
        }
    }

    public function start(): void
    {
        if ($this->maxParallelism <= count($this->processRegistry)) {
            return;
        }

        while ($this->maxParallelism > count($this->currentTasks)) {
            $taskRunner = $this->taskQueue->dequeue();

            if ($taskRunner->finished()) {
                continue;
            }

            $this->currentTasks[] = $taskRunner;
        }

        foreach ($this->currentTasks as $taskRunner) {
            $taskRunner->next();
        }
    }

    public function poll(callable $onFinish): void
    {
        $currentTasks = $this->currentTasks;
        $this->currentTasks = [];
        foreach ($currentTasks as $taskRunner) {
            if ($taskRunner->isBusy()) {
                $this->currentTasks[] = $taskRunner;
                continue;
            }

            if (!$taskRunner->finished()) {
                $taskRunner->next();
                $this->currentTasks[] = $taskRunner;
                continue;
            }

            $this->currentTasks[] = $taskRunner = $this->taskQueue->dequeue();
            $onFinish();
            $taskRunner->next();
        }
    }

    public function finished(): bool
    {
        return count($this->taskQueue) + count($this->currentTasks) <= 0;
    }
}