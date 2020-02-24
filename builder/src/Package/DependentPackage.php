<?php declare(strict_types=1);

namespace Builder\Package;

use Builder\DependentTag;
use Builder\TagReference;

final class DependentPackage implements DependentPackageInterface, \IteratorAggregate
{
    public string $name;
    public string $parent;
    /** @var EditionInterface[] */
    public array $editions;

    public function __construct(string $name, string $parent, EditionInterface ...$editions)
    {
        $this->name = $name;
        $this->parent = $parent;
        $this->editions = $editions;
    }

    public function getIterator()
    {
        foreach ($this() as $parts) {
            yield new DependentTag(
                strtr('%php.version%-%php.flavor%-%package.name%-%package.edition%-%package.version%-%package.variation%', $parts),
                new TagReference(strtr('%php.version%-%php.flavor%-%package.name%-%package.edition%-%package.version%-%package.variation%', [
                    '%package.name%' => $this->parent,
                ] + $parts))
            );
        }
    }

    public function __invoke(): \Traversable
    {
        foreach ($this->editions as $edition) {
            foreach ($edition() as $parts) {
                yield $parts + [
                    '%package.name%' => $this->name,
                ];
            }
        }
    }
}