<?php declare(strict_types=1);

namespace Builder\Package;

use Builder\DependencyTree\NodeInterface;

interface DependencyResolvableInterface
{
    public function resolve(iterable $tags): NodeInterface;
}