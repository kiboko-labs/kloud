<?php declare(strict_types=1);

namespace Builder\Package;

use Builder\DependentTag;
use Builder\TagReference;

final class Edition implements EditionInterface, \IteratorAggregate
{
    public string $name;
    /** @var VersionInterface[] */
    public array $versions;

    public function __construct(string $name, VersionInterface ...$versions)
    {
        $this->name = $name;
        $this->versions = $versions;
    }

    public function getIterator()
    {
        foreach ($this() as $parts) {
            yield new DependentTag(
                strtr('%php.version%-%php.flavor%-%package.edition%-%package.version%-%package.variation%', $parts),
                new TagReference(strtr('%php.version%-%php.flavor%-%package.variation%', $parts))
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