<?php declare(strict_types=1);

namespace Builder\Domain\Packaging\Platform\Edition;

use Exception;
use Traversable;

final class MarelloEnterpriseEditionRepository implements EditionRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        // Uses Marello CE 1.2
        yield new EditionDependency(
            'marello',
            '1.0',
            'ee',
            new Edition(
                'oroplatform',
                '2.5',
                'ee'
            )
        );

        // Uses Marello CE 1.3
        yield new EditionDependency(
            'marello',
            '1.1',
            'ee',
            new Edition(
                'oroplatform',
                '2.5',
                'ee'
            )
        );

        // Uses Marello CE 1.4
        yield new EditionDependency(
            'marello',
            '1.2',
            'ee',
            new Edition(
                'oroplatform',
                '2.6',
                'ee'
            )
        );

        // Uses Marello CE 1.5
        yield new EditionDependency(
            'marello',
            '1.3',
            'ee',
            new Edition(
                'oroplatform',
                '2.6',
                'ee'
            )
        );

        // Uses Marello CE 2.0
        yield new EditionDependency(
            'marello',
            '2.0',
            'ee',
            new Edition(
                'oroplatform',
                '3.1',
                'ee'
            )
        );

        // Uses Marello CE 2.1
        yield new EditionDependency(
            'marello',
            '2.1',
            'ee',
            new Edition(
                'oroplatform',
                '3.1',
                'ee'
            )
        );

        // Uses Marello CE 2.2
        yield new EditionDependency(
            'marello',
            '2.2',
            'ee',
            new Edition(
                'oroplatform',
                '3.1',
                'ee'
            )
        );

        // Uses Marello CE 3.0
        yield new EditionDependency(
            'marello',
            '3.0',
            'ee',
            new Edition(
                'oroplatform',
                '4.1',
                'ee'
            )
        );
    }
}