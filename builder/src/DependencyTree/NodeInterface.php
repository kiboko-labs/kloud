<?php

namespace Builder\DependencyTree;

use Builder\Command;

interface NodeInterface extends \Countable, \Traversable
{
    public function __toString();

    public function build(Command\CommandCompositeInterface $commands): void;

    public function add(NodeInterface ...$edges);
    public function resolve(ResolutionInterface $resolved, ResolutionInterface $processed): void;
}