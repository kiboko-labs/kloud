<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Native;

use Kiboko\Cloud\Domain\Packaging;
use Kiboko\Cloud\Domain\Packaging\Native;
use Kiboko\Cloud\PHP\FlavorInterface;

final class PackageVariation implements \IteratorAggregate, Packaging\PackageInterface, Packaging\BuildableInterface
{
    private Packaging\RepositoryInterface $repository;
    public string $number;
    private Packaging\Placeholder $path;
    private Native\Flavor\FlavorRepositoryInterface $flavors;
    private Native\Variation\PackageVariationInterface $variations;
    private bool $withExperimental;

    public function __construct(
        Packaging\RepositoryInterface $repository,
        string $number,
        Packaging\Placeholder $path,
        Native\Flavor\FlavorRepositoryInterface $flavors,
        Native\Variation\PackageVariationInterface $variations,
        bool $withExperimental = false
    ) {
        $this->repository = $repository;
        $this->number = $number;
        $this->path = $path;
        $this->flavors = $flavors;
        $this->variations = $variations;
        $this->withExperimental = $withExperimental;
    }

    public function __invoke(): \Traversable
    {
        foreach ($this->flavors as $flavor) {
            foreach ($this->variations as $variation) {
                yield new Packaging\Context\BuildableContext(
                    null,
                    $this->path,
                    [
                        '%php.version%' => $this->number,
                        '%php.flavor%' => $flavor,
                        '%package.variation%' => $variation,
                    ]
                );
            }
        }
    }

    public function getIterator()
    {
        /** @var Packaging\Context\BuildableContextInterface $context */
        foreach ($this() as $context) {
            yield new Native\TagVariation($this->repository, new TagReference($this->repository, $context), $context);
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