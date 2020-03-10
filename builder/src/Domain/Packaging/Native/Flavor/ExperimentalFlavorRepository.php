<?php declare(strict_types=1);

namespace Builder\Domain\Packaging\Native\Flavor;

use Exception;
use Traversable;

final class ExperimentalFlavorRepository implements FlavorRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield 'fpm';
        yield 'cli';
    }
}