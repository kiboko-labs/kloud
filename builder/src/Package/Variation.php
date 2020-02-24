<?php declare(strict_types=1);

namespace Builder\Package;

use Builder\DependentTag;
use Builder\PHP;
use Builder\TagReference;

final class Variation implements VariationInterface, \IteratorAggregate
{
    public string $name;
    /** @var VersionInterface[] */
    public array $versions;

    public function __construct(string $name, PHP\VersionInterface ...$versions)
    {
        $this->name = $name;
        $this->versions = $versions;
    }

    public function getIterator()
    {
        foreach ($this() as $parts) {
            yield new DependentTag(
                strtr('%php.version%-%php.flavor%-%package.variation%', $parts),
                new TagReference(strtr('%php.version%-%php.flavor%', $parts))
            );
        }
    }

    public function __invoke(): \Traversable
    {
        foreach ($this->versions as $version) {
            foreach ($version() as $parts) {
                yield $parts + [
                    '%package.variation%' => $this->name,
                ];
            }
        }
    }
}