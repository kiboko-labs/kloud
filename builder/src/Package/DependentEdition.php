<?php declare(strict_types=1);

namespace Builder\Package;

use Builder\DependentTag;
use Builder\TagReference;

final class DependentEdition implements DependentEditionInterface, \IteratorAggregate
{
    public string $name;
    public string $parent;
    /** @var VersionInterface[] */
    public array $versions;

    public function __construct(string $name, string $parent, VersionInterface ...$versions)
    {
        $this->name = $name;
        $this->parent = $parent;
        $this->versions = $versions;
    }

    public function getIterator()
    {
        foreach ($this() as $parts) {
            yield new DependentTag(
                strtr('%php.version%-%php.flavor%-%package.edition%-%package.version%-%package.variation%', $parts),
                new TagReference(strtr('%php.version%-%php.flavor%-%package.edition%-%package.version%-%package.variation%', [
                    '%package.edition%' => $this->parent,
                ] + $parts))
            );
        }
    }

    public function __invoke(): \Traversable
    {
        foreach ($this->versions as $version) {
            foreach ($version() as $parts) {
                yield $parts + [
                    '%package.edition%' => $this->name,
                ];
            }
        }
    }
}