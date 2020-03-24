<?php declare(strict_types=1);

namespace Builder\Domain\Packaging\Native;

use Builder\Domain\Packaging;
use Builder\Domain\Packaging\Native;
use Builder\PHP\FlavorInterface;

final class PackageVariation implements \IteratorAggregate, Packaging\PackageInterface, Packaging\BuildableInterface
{
    private Packaging\RepositoryInterface $repository;
    public string $number;
    private Packaging\Placeholder $path;
    private Native\Flavor\FlavorRepositoryInterface $flavors;
    private Native\Variation\PackageVariationInterface $variations;

    public function __construct(
        Packaging\RepositoryInterface $repository,
        string $number,
        Packaging\Placeholder $path,
        Native\Flavor\FlavorRepositoryInterface $flavors,
        Native\Variation\PackageVariationInterface $variations
    ) {
        $this->repository = $repository;
        $this->number = $number;
        $this->path = $path;
        $this->flavors = $flavors;
        $this->variations = $variations;
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