<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Platform\Edition;

final class MarelloEnterpriseEditionRepository implements EditionRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield new EditionDependency(
            'marello',
            '1.2',
            'ee',
            new Edition(
                'marello',
                '1.4',
                'ce',
                '>=7.1 <7.2'
            )
        );

        yield new EditionDependency(
            'marello',
            '1.3',
            'ee',
            new Edition(
                'marello',
                '1.5',
                'ce',
                '>=7.1 <7.2'
            )
        );

        yield new EditionDependency(
            'marello',
            '2.0',
            'ee',
            new Edition(
                'marello',
                '2.0',
                'ce',
                '>=7.1 <7.3',
                '>=7.1 <=8.0'
            )
        );

        yield new EditionDependency(
            'marello',
            '2.1',
            'ee',
            new Edition(
                'marello',
                '2.1',
                'ce',
                '>=7.1 <7.3',
                '>=7.1 <=8.0'
            )
        );

        yield new EditionDependency(
            'marello',
            '2.2',
            'ee',
            new Edition(
                'marello',
                '2.2',
                'ce',
                '>=7.1 <7.3',
                '>=7.1 <=8.0'
            )
        );

        yield new EditionDependency(
            'marello',
            '3.0',
            'ee',
            new Edition(
                'marello',
                '3.0',
                'ce',
                '>=7.3 <8.0',
                '>=7.3 <=8.0'
            )
        );
    }
}
