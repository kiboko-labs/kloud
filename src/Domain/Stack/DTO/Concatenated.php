<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\DTO;

final class Concatenated implements \Stringable
{
    private iterable $components;

    /**
     * @param \Stringable|string $components
     */
    public function __construct(...$components)
    {
        $this->components = $components;
    }

    private function walk(): \Iterator
    {
        foreach ($this->components as $component) {
            yield (string) $component;
        }
    }

    public function __toString()
    {
        return implode('', iterator_to_array($this->walk()));
    }
}