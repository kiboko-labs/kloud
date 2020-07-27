<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Native\PHP\Flavor;

final class StandardFlavorRepository implements FlavorRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield 'fpm';
        yield 'cli';
        yield 'fpm-xdebug';
        yield 'cli-xdebug';
        yield 'fpm-blackfire';
        yield 'cli-blackfire';
    }
}