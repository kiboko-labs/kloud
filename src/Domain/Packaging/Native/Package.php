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

    public function __construct(
        Packaging\RepositoryInterface $repository,
        string $number,
        Packaging\Placeholder $path,
        Native\Flavor\FlavorRepositoryInterface $flavors
    ) {
        $this->repository = $repository;
        $this->number = $number;
        $this->path = $path;
        $this->flavors = $flavors;
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

    public function pull(Packaging\CommandBus\CommandBusInterface $commands): void
    {
        /** @var Packaging\Tag\TagBuildInterface $tag */
        foreach ($this as $tag) {
            $tag->pull($commands);
        }
    }

    public function push(Packaging\CommandBus\CommandBusInterface $commands): void
    {
        /** @var Packaging\Tag\TagBuildInterface $tag */
        foreach ($this as $tag) {
            $tag->push($commands);
        }
    }

    public function build(Packaging\CommandBus\CommandBusInterface $commands): void
    {
        /** @var Packaging\Tag\TagBuildInterface $tag */
        foreach ($this as $tag) {
            $tag->build($commands);
        }
    }

    public function forceBuild(Packaging\CommandBus\CommandBusInterface $commands): void
    {
        /** @var Packaging\Tag\TagBuildInterface $tag */
        foreach ($this as $tag) {
            $tag->forceBuild($commands);
        }
    }
}