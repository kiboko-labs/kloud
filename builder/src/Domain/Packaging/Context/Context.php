<?php

declare(strict_types=1);

namespace Builder\Domain\Packaging\Context;

final class Context implements ContextInterface, \IteratorAggregate
{
    use ContextTrait;

    public function __construct(
        ?ContextInterface $parent,
        array $variables = []
    ) {
        $this->parent = $parent;
        $this->localVariables = $variables;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getArrayCopy());
    }

    public function getBuildableParent(?string $path = null, array $variables = []): ?BuildableContextInterface
    {
        if (null === $this->parent) {
            return null;
        }

        return $this->parent->asBuildable($path, $variables);
    }

    public function asBuildable(?string $path = null, array $variables = []): BuildableContextInterface
    {
        return new BuildableContext($this->parent, $path, $variables + $this->getLocalArrayCopy());
    }

    public function hasParent(): bool
    {
        return null !== $this->parent;
    }

    public function getParent(): ContextInterface
    {
        return null !== $this->parent ? clone $this->parent : new Context(null);
    }

    public function dependencyOrParent(): ContextInterface
    {
        return clone $this;
    }
}
