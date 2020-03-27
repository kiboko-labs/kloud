<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Platform\Edition;

final class MarelloEnterpriseEditionRepository implements EditionRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield new EditionDependency(
            'marello',
            '1.5',
            'ee',
            new Edition(
                'oroplatform',
                '2.6',
                'ee',
                '>=5.6 <7.2'
            )
        );
        yield new EditionDependency(
            'marello',
            '1.6',
            'ee',
            new Edition(
                'oroplatform',
                '2.6',
                'ee',
                '>=5.6 <7.2'
            )
        );

        yield new EditionDependency(
            'marello',
            '2.0',
            'ee',
            new Edition(
                'oroplatform',
                '3.1',
                'ee',
                '>=7.1 <8.0'
            )
        );

        yield new EditionDependency(
            'marello',
            '2.1',
            'ee',
            new Edition(
                'oroplatform',
                '3.1',
                'ee',
                '>=7.1 <8.0'
            )
        );

        yield new EditionDependency(
            'marello',
            '2.2',
            'ee',
            new Edition(
                'oroplatform',
                '3.1',
                'ee',
                '>=7.1 <8.0'
            )
        );

        yield new EditionDependency(
            'marello',
            '3.0',
            'ee',
            new Edition(
                'oroplatform',
                '4.1',
                'ee',
                '>=7.3 <8.0'
            )
        );
    }
}