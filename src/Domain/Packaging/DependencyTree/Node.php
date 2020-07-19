<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\DependencyTree;

use Kiboko\Cloud\Domain\Packaging\Execution\CommandBus;
use Kiboko\Cloud\Domain\Packaging;
use Kiboko\Cloud\Domain\Packaging\Placeholder;

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

    public function pull(CommandBus\Task $task): CommandBus\Task
    {
        $this->tag->pull($task);

        return $task;
    }

    public function push(CommandBus\Task $task): CommandBus\Task
    {
        $this->tag->push($task);

        return $task;
    }

    public function build(CommandBus\Task $task): CommandBus\Task
    {
        $this->tag->build($task);

        return $task;
    }

    public function forceBuild(CommandBus\Task $task): CommandBus\Task
    {
        $this->tag->forceBuild($task);

        return $task;
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
