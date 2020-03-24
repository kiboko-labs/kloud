<?php

namespace Kiboko\Cloud\DependencyTree;

namespace Kiboko\Cloud\Domain\Packaging\DependencyTree;

use Kiboko\Cloud\Domain\Packaging;

interface NodeInterface extends Packaging\BuildableInterface, \Countable, \Traversable, \Stringable
{
    public function getPath(): ?Packaging\Placeholder;

    public function add(NodeInterface ...$edges): void;

    public function resolve(ResolutionInterface $resolved, ResolutionInterface $processed): void;
}
