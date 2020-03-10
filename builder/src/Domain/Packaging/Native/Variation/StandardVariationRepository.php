<?php declare(strict_types=1);

namespace Builder\Domain\Packaging\Native\Variation;

final class StandardVariationRepository implements PackageVariationInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield 'mysql';
        yield 'postgresql';
    }
}