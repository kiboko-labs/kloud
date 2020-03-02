<?php

namespace Builder\DependencyTree;

use Builder\BuildableInterface;

interface NodeInterface extends BuildableInterface, \Countable, \Traversable
{
    public function __toString();
    public function getPath(): string;

    public function add(NodeInterface ...$edges);
    public function resolve(ResolutionInterface $resolved, ResolutionInterface $processed): void;
}