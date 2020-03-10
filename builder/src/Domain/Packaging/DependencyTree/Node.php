<?php

declare(strict_types=1);

namespace Builder\Domain\Packaging\DependencyTree;

use Builder\Domain\Packaging\CommandBus;
use Builder\Domain\Packaging;
use Builder\Domain\Packaging\Placeholder;
use phpDocumentor\Reflection\Types\String_;

final class Node implements NodeInterface, \IteratorAggregate
{
    private Packaging\Tag\TagInterface $tag;
    /** @var NodeInterface[] */
    private array $edges;
    public ?NodeInterface $parent;

    public function __construct(Packaging\Tag\TagInterface $tag, NodeInterface ...$edges)
    {
        $this->tag = $tag;
        $this->edges = [];
        $this->add(...$edges);
        $this->parent = null;
    }

    public function __toString()
    {
        return (string) $this->tag;
    }

    public function getPath(): ?Placeholder
    {
        return ($context = $this->tag->getContext()) instanceof Packaging\Context\BuildableContextInterface
            ? $context->getPath()
            : null;
    }

    public function count()
    {
        return count($this->edges);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->edges);
    }

    public function pull(CommandBus\CommandBusInterface $commands): void
    {
        $this->tag->pull($commands);
    }

    public function push(CommandBus\CommandBusInterface $commands): void
    {
        $this->tag->push($commands);
    }

    public function build(CommandBus\CommandBusInterface $commands): void
    {
        $this->tag->build($commands);
    }

    public function forceBuild(CommandBus\CommandBusInterface $commands): void
    {
        $this->tag->forceBuild($commands);
    }

    public function add(NodeInterface ...$edges): void
    {
        array_push($this->edges, ...$edges);

        $parent = $this;
        array_walk($edges, function (NodeInterface $node) use ($parent) {
            $node->parent = $parent;
        });
    }

    public function resolve(ResolutionInterface $resolved, ResolutionInterface $processed): void
    {
        $processed->push($this);

        foreach ($this->edges as $dependency) {
            $dependency->resolve($resolved, $processed);
        }

        $resolved->push($this);
    }
}
