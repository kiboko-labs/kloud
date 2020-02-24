<?php declare(strict_types=1);

namespace Builder\Package;

use Builder\DependentTag;
use Builder\TagReference;

final class Version implements VersionInterface, \IteratorAggregate
{
    public string $name;
    /** @var VariationInterface[] */
    public array $variations;

    public function __construct(string $name, VariationInterface ...$variations)
    {
        $this->name = $name;
        $this->variations = $variations;
    }

    public function getIterator()
    {
        foreach ($this() as $parts) {
            yield new DependentTag(
                strtr('%php.version%-%php.flavor%-%package.version%-%package.variation%', $parts),
                new TagReference(strtr('%php.version%-%php.flavor%-%package.variation%', $parts)),
            );
        }
    }

    public function __invoke(): \Traversable
    {
        foreach ($this->variations as $variation) {
            foreach ($variation() as $parts) {
                yield $parts + [
                    '%package.version%' => $this->name,
                ];
            }
        }
    }
}