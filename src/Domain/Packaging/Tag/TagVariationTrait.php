<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Tag;

use Kiboko\Cloud\Domain\Packaging;

trait TagVariationTrait
{
    private Packaging\RepositoryInterface $repository;
    private Packaging\Placeholder $name;
    private Packaging\Context\BuildableContextInterface $context;
    private Packaging\Tag\TagInterface $from;

    public function getContext(): Packaging\Context\ContextInterface
    {
        return $this->context;
    }

    public function __toString()
    {
        return (string) $this->name;
    }

    public function getRepository(): Packaging\RepositoryInterface
    {
        return $this->repository;
    }

    public function getParent(): Packaging\Tag\TagInterface
    {
        return $this->from;
    }

    public function pull(Packaging\Execution\CommandBus\Task $task): Packaging\Execution\CommandBus\Task
    {
        $task->then(new Packaging\Execution\Command\Pull($this));

        return $task;
    }

    public function push(Packaging\Execution\CommandBus\Task $task): Packaging\Execution\CommandBus\Task
    {
        $task->then(new Packaging\Execution\Command\Push($this));

        return $task;
    }

    public function build(Packaging\Execution\CommandBus\Task $task): Packaging\Execution\CommandBus\Task
    {
        $task->then(new Packaging\Execution\Command\BuildFrom($this, $this->from, $this->context));

        return $task;
    }

    public function forceBuild(Packaging\Execution\CommandBus\Task $task): Packaging\Execution\CommandBus\Task
    {
        $task->then(new Packaging\Execution\Command\ForceBuildFrom($this, $this->from, $this->context));

        return $task;
    }
}
