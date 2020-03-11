<?php declare(strict_types=1);

namespace Builder\Domain\Packaging\Platform\Edition;

use Exception;
use Traversable;

final class MarelloCommunityEditionRepository implements EditionRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
//        yield new EditionDependency(
//            'marello',
//            '1.0',
//            'ce',
//            new Edition(
//                'oroplatform',
//                '2.0',
//                'ce'
//            )
//        );
//
//        yield new EditionDependency(
//            'marello',
//            '1.1',
//            'ce',
//            new Edition(
//                'oroplatform',
//                '2.0',
//                'ce'
//            )
//        );
//
        yield new EditionDependency(
            'marello',
            '1.2',
            'ce',
            new Edition(
                'oroplatform',
                '2.5',
                'ce'
            )
        );

        yield new EditionDependency(
            'marello',
            '1.3',
            'ce',
            new Edition(
                'oroplatform',
                '2.5',
                'ce'
            )
        );

        yield new EditionDependency(
            'marello',
            '1.4',
            'ce',
            new Edition(
                'oroplatform',
                '2.6',
                'ce'
            )
        );

        yield new EditionDependency(
            'marello',
            '1.5',
            'ce',
            new Edition(
                'oroplatform',
                '2.6',
                'ce'
            )
        );

        yield new EditionDependency(
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
            '2.2',
            'ce',
            new Edition(
                'oroplatform',
                '3.1',
                'ce'
            )
        );

        yield new EditionDependency(
            'marello',
            '3.0',
            'ce',
            new Edition(
                'oroplatform',
                '4.1',
                'ce'
            )
        );
    }
}