<?php

declare(strict_types=1);

namespace Builder\Domain\Packaging\DependencyTree;

final class Processed implements ResolutionInterface, \IteratorAggregate
{
    /** @var Node[] */
    private array $nodes;

    public function __construct(NodeInterface ...$nodes)
    {
        $this->nodes = array_unique($nodes);
    }

    public function has(string $tag): bool
    {
        return 0 < count(array_filter($this->nodes, function (NodeInterface $node) use ($tag) {
            return $tag === (string) $node;
        }));
    }

    public function find(string $tag): ?NodeInterface
    {
        return array_shift(array_filter($this->nodes, function (NodeInterface $node) use ($tag) {
            return $tag === (string) $node;
        }));
    }

    public function push(NodeInterface ...$nodes): void
    {
        foreach ($nodes as $node) {
            if ($this->has((string) $node)) {
                throw new \RuntimeException(strtr('Circular dependency found for packages %current%, previously got: %packages%.', [
                    '%current%' => (string) $node,
                    '%packages%' => implode(', ', array_map(function (NodeInterface $node) {
                        return (string) $node;
                    }, $this->nodes)),
                ]));
            }
        }

        array_push($this->nodes, ...array_diff(array_unique($nodes), $this->nodes));
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->nodes);
    }
}
