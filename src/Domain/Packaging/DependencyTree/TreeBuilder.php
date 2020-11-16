<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\DependencyTree;

use Kiboko\Cloud\Domain\Packaging;

final class TreeBuilder implements \IteratorAggregate
{
    private ResolutionInterface $repository;

    public function __construct()
    {
        $this->repository = new Resolved();
    }

    public function build(Packaging\Tag\TagInterface ...$packages): void
    {
        foreach ($packages as $package) {
            $node = new Node($package);

            $this->repository->push($node);

            if (!$package instanceof Packaging\Tag\DependentTagInterface) {
                continue;
            }

            $parent = $this->repository->find(sprintf('%s:%s', (string) $package->getParent()->getRepository(), (string) $package->getParent()));

            if (null === $parent) {
                throw new \RuntimeException(strtr('The parent package %parent%, for package %package% was not found.', ['%package%' => (string) $package, '%parent%' => (string) $package->getParent()]));
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
