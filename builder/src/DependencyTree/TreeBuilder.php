<?php declare(strict_types=1);

namespace Builder\DependencyTree;

use Builder\BuildableTagInterface;
use Builder\DependentTagInterface;
use Traversable;

final class TreeBuilder implements \IteratorAggregate
{
    private ResolutionInterface $repository;

    public function __construct()
    {
        $this->repository = new Resolved();
    }

    public function build(BuildableTagInterface ...$packages): void
    {
        foreach ($packages as $package) {
            $node = new Node($package);

            $this->repository->push($node);

            if (!$package instanceof DependentTagInterface) {
                continue;
            }

            $parent = $this->repository->find((string) $package->getParent());

            if ($parent === null) {
                throw new \RuntimeException(strtr('The parent package %parent%, for package %package% was not found.', [
                    '%package%' => (string) $package,
                    '%parent%' => (string) $package->getParent(),
                ]));
            }

            $node->add($parent);
        }
    }

    public function getIterator()
    {
        return $this->repository;
    }

    public function resolve(Node ...$nodes): \Traversable
    {
        $resolved = new Resolved();

        foreach ($nodes as $node) {
            $processed = new Processed();
            $node->resolve($resolved, $processed);
        }

        yield from $resolved;
    }
}