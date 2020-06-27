<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Platform\Edition;

final class MarelloCommunityEditionRepository implements EditionRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield new EditionDependency(
            'marello',
            '1.5',
            'ce',
            new Edition(
                'oroplatform',
                '2.6',
                'ce',
                '>=5.6 <7.2'
            )
        );
        yield new EditionDependency(
            'marello',
            '1.6',
            'ce',
            new Edition(
                'oroplatform',
                '2.6',
                'ce',
                '>=5.6 <7.2'
            )
        );

        yield new EditionDependency(
            'marello',
            '2.0',
            'ce',
            new Edition(
                'oroplatform',
                '3.1',
                'ce',
                '>=7.1 <8.1'
            )
        );

        yield new EditionDependency(
            'marello',
            '2.1',
            'ce',
            new Edition(
                'oroplatform',
                '3.1',
                'ce',
                '>=7.1 <8.1'
            )
        );

        yield new EditionDependency(
            'marello',
            '2.2',
            'ce',
            new Edition(
                'oroplatform',
                '3.1',
                'ce',
                '>=7.1 <8.1'
            )
        );

        yield new EditionDependency(
            'marello',
            '3.0',
            'ce',
            new Edition(
                'oroplatform',
                '4.1',
                'ce',
                '>=7.3 <9.0'
            )
        );
    }
}