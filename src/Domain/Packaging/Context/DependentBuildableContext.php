<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Context;

use Kiboko\Cloud\Domain\Packaging\Placeholder;

final class DependentBuildableContext implements BuildableContextInterface, \IteratorAggregate
{
    use ContextTrait;

    private ContextInterface $dependency;
    private Placeholder $path;

    public function __construct(
        ?ContextInterface $parent,
        BuildableContextInterface $dependency,
        ?Placeholder $path,
        array $variables = []
    ) {
        $this->parent = $parent;
        $this->localVariables = $variables;
        $this->dependency = $dependency;

        if (null === $path) {
            if (!$parent instanceof BuildableContextInterface) {
                throw new \RuntimeException('Could not determine path from parent context, please provide a path for the context.');
            }

            $this->path = $parent->getPath()->reset($variables);
        } else {
            $this->path = $path->merge($variables);
        }
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getArrayCopy());
    }

    public function getPath(): Placeholder
    {
        return $this->path->reset($this->getArrayCopy());
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
        return new self($this->parent, $this->dependency, $path ?? $this->path, $variables);
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
        return clone $this->dependency;
    }
}
