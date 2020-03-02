<?php declare(strict_types=1);

namespace Builder\DependencyTree;

use Builder\BuildableTagInterface;
use Builder\Command;

final class Node implements NodeInterface, \IteratorAggregate
{
    private BuildableTagInterface $tag;
    /** @var Node[] */
    private array $edges;
    public ?NodeInterface $parent;

    public function __construct(BuildableTagInterface $tag, NodeInterface ...$edges)
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

    public function getPath(): string
    {
        return $this->tag->getPath();
    }

    public function count()
    {
        return count($this->edges);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->edges);
    }

    public function pull(Command\CommandBusInterface $commands): void
    {
        $this->tag->pull($commands);
    }

    public function push(Command\CommandBusInterface $commands): void
    {
        $this->tag->push($commands);
    }

    public function build(Command\CommandBusInterface $commands): void
    {
        $this->tag->build($commands);
    }

    public function forceBuild(Command\CommandBusInterface $commands): void
    {
        $this->tag->forceBuild($commands);
    }

    public function add(NodeInterface ...$edges)
    {
        array_push($this->edges, ...$edges);
        array_walk($edges, function(NodeInterface $node) {
            $node->parent = $this;
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