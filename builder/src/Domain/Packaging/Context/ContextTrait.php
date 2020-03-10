<?php

declare(strict_types=1);

namespace Builder\Domain\Packaging\Context;

trait ContextTrait
{
    private array $localVariables;
    private ?ContextInterface $parent;

    public function offsetExists($offset)
    {
        return isset($this->localVariables[$offset]) || isset($this->parent[$offset]);
    }

    public function offsetGet($offset)
    {
        if (null === $this->parent) {
            return $this->localVariables[$offset] ?? null;
        }

        return $this->localVariables[$offset] ?? $this->parent[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->localVariables[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->localVariables[$offset]);
    }

    public function getArrayCopy(): array
    {
        if (null === $this->parent) {
            return $this->localVariables;
        }

        return $this->localVariables + $this->parent->getArrayCopy();
    }

    public function getLocalArrayCopy(): array
    {
        if (null === $this->parent) {
            return $this->localVariables;
        }

        return $this->localVariables + $this->parent->getArrayCopy();
    }

    public function update(array $variables = []): void
    {
        foreach ($variables as $key => $variable) {
            $this[$key] = $variable;
        }
    }

    public function merge(ContextInterface $source): void
    {
        $this->update($source->getLocalArrayCopy());
    }

    public function count()
    {
        return count($this->getArrayCopy());
    }
}
