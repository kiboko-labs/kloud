<?php

namespace Builder\DependencyTree;

interface ResolutionInterface extends \Traversable
{
    public function has(string $tag): bool;
    public function find(string $tag): ?NodeInterface;

    public function push(Node ...$nodes): void;
}