<?php

namespace Builder\Domain\Packaging\DependencyTree;

interface ResolutionInterface extends \Traversable
{
    public function has(string $tag): bool;

    public function find(string $tag): ?NodeInterface;

    public function push(NodeInterface ...$nodes): void;
}
