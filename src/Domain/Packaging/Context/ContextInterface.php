<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Context;

interface ContextInterface extends \ArrayAccess, \Countable, \Traversable
{
    public function getArrayCopy(): array;

    public function getLocalArrayCopy(): array;

    public function update(array $variables = []): void;

    public function merge(ContextInterface $source): void;

    public function getBuildableParent(?string $path = null, array $variables = []): ?BuildableContextInterface;

    public function asBuildable(?string $path = null, array $variables = []): BuildableContextInterface;

    public function hasParent(): bool;

    public function getParent(): ?ContextInterface;

    public function dependencyOrParent(): ContextInterface;
}
