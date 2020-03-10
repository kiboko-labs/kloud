<?php declare(strict_types=1);

namespace Builder\Domain\Packaging\Platform\Edition;

use Exception;
use Traversable;

final class MarelloEditionRepository implements EditionRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield $parent = new EditionDependency(
            'marello',
            '1.5',
            'ce',
            new Edition(
                'oroplatform',
                '1.6',
                'ce'
            )
        );
        yield new EditionDependency(
            'marello',
            '1.5',
            'ee',
            $parent
        );

        yield $parent = new EditionDependency(
            'marello',
            '1.6',
            'ce',
            new Edition(
                'oroplatform',
                '1.6',
                'ce'
            )
        );
        yield new EditionDependency(
            'marello',
            '1.6',
            'ee',
            $parent
        );

        yield $parent = new EditionDependency(
            'marello',
            '2.0',
            'ce',
            new Edition(
                'oroplatform',
                '3.1',
                'ce'
            )
        );
        yield new EditionDependency(
            'marello',
            '2.0',
            'ee',
            $parent
        );

        yield $parent = new EditionDependency(
            'marello',
            '2.1',
            'ce',
            new Edition(
                'oroplatform',
                '3.1',
                'ce'
            )
        );
        yield new EditionDependency(
            'marello',
            '2.1',
            'ee',
            $parent
        );

        yield $parent = new EditionDependency(
            'marello',
            '3.0',
            'ce',
            new Edition(
                'oroplatform',
                '4.1',
                'ce'
            )
        );
        yield new EditionDependency(
            'marello',
            '3.0',
            'ee',
            $parent
        );
    }
}