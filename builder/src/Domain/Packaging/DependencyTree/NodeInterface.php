<?php

namespace Builder\DependencyTree;

namespace Builder\Domain\Packaging\DependencyTree;

use Builder\Domain\Packaging;

interface NodeInterface extends Packaging\BuildableInterface, \Countable, \Traversable
{
    public function __toString();

    public function getPath(): ?Packaging\Placeholder;

    public function add(NodeInterface ...$edges): void;

    public function resolve(ResolutionInterface $resolved, ResolutionInterface $processed): void;
}
