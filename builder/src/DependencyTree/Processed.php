<?php declare(strict_types=1);

namespace Builder\DependencyTree;

use Builder\TagInterface;

final class Processed implements ResolutionInterface, \IteratorAggregate
{
    /** @var Node[] */
    private array $nodes;

    public function __construct(Node ...$nodes)
    {
        $this->nodes = array_unique($nodes);
    }

    public function has(string $tag): bool
    {
        return 0 < count(array_filter($this->nodes, function (NodeInterface $node) use ($tag) {
                return ($tag === (string) $node);
            }));
    }

    public function find(string $tag): ?NodeInterface
    {
        return array_shift(array_filter($this->nodes, function (NodeInterface $node) use ($tag) {
            return ($tag === (string) $node);
        }));
    }

    public function push(Node ...$nodes): void
    {
        foreach ($nodes as $node) {
            if ($this->has((string) $node)) {
                throw new \RuntimeException(strtr('Circular dependency found for packages %packages%.', ['%packages%' => (string) $node]));
            }
        }

        array_push($this->nodes, ...array_diff(array_unique($nodes), $this->nodes));
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->nodes);
    }
}