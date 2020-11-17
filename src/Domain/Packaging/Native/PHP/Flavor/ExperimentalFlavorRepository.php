<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Native\PHP\Flavor;

final class ExperimentalFlavorRepository implements FlavorRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield 'fpm';
        yield 'cli';
        yield 'fpm-xdebug';
        yield 'cli-xdebug';
    }
}
