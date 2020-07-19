<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Native;

use Kiboko\Cloud\Domain\Packaging;
use Kiboko\Cloud\Domain\Packaging\Native;

final class Package implements \IteratorAggregate, Packaging\PackageInterface, Packaging\BuildableInterface
{
    private Packaging\RepositoryInterface $repository;
    public string $number;
    private Packaging\Placeholder $path;
    private Native\Flavor\FlavorRepositoryInterface $flavors;
    private bool $withExperimental;

    public function __construct(
        Packaging\RepositoryInterface $repository,
        string $number,
        Packaging\Placeholder $path,
        Native\Flavor\FlavorRepositoryInterface $flavors,
        bool $withExperimental = false
    ) {
        $this->repository = $repository;
        $this->number = $number;
        $this->path = $path;
        $this->flavors = $flavors;
        $this->withExperimental = $withExperimental;
    }

    public function __invoke(): \Traversable
    {
        foreach ($this->flavors as $flavor) {
            yield new Packaging\Context\BuildableContext(
                null,
                $this->path,
                [
                    '%php.version%' => $this->number,
                    '%php.flavor%' => $flavor,
                ]
            );
        }
    }

    public function getIterator()
    {
        /** @var Packaging\Context\BuildableContextInterface $context */
        foreach ($this() as $context) {
            yield new Native\Tag($this->repository, $context);
        }
    }

    public function pull(Packaging\Execution\CommandBus\Task $task): Packaging\Execution\CommandBus\Task
    {
        /** @var Packaging\Tag\TagBuildInterface $tag */
        foreach ($this as $tag) {
            $tag->pull($task);
        }

        return $task;
    }

    public function push(Packaging\Execution\CommandBus\Task $task): Packaging\Execution\CommandBus\Task
    {
        /** @var Packaging\Tag\TagBuildInterface $tag */
        foreach ($this as $tag) {
            $tag->push($task);
        }

        return $task;
    }

    public function build(Packaging\Execution\CommandBus\Task $task): Packaging\Execution\CommandBus\Task
    {
        /** @var Packaging\Tag\TagBuildInterface $tag */
        foreach ($this as $tag) {
            $tag->build($task);
        }

        return $task;
    }

    public function forceBuild(Packaging\Execution\CommandBus\Task $task): Packaging\Execution\CommandBus\Task
    {
        /** @var Packaging\Tag\TagBuildInterface $tag */
        foreach ($this as $tag) {
            $tag->forceBuild($task);
        }

        return $task;
    }
}