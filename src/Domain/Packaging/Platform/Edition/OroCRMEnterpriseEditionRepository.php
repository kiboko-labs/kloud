<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Platform\Edition;

final class OroCRMEnterpriseEditionRepository implements EditionRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield new EditionDependency(
            'orocrm',
            '1.8',
            'ee',
            new Edition(
                'orocrm',
                '1.6',
                'ce',
                '>=5.4 <7.0'
            )
        );

        yield new EditionDependency(
            'orocrm',
            '1.10',
            'ee',
            new Edition(
                'orocrm',
                '1.8',
                'ce',
                '>=5.4 <7.0'
            )
        );

        yield new EditionDependency(
            'orocrm',
            '1.12',
            'ee',
            new Edition(
                'orocrm',
                '1.10',
                'ce',
                '>=5.5 <7.0'
            )
        );

        yield new EditionDependency(
            'orocrm',
            '2.6',
            'ee',
            new Edition(
                'orocrm',
                '2.6',
                'ce',
                '>=5.6 <7.2'
            )
        );

        yield new EditionDependency(
            'orocrm',
            '3.1',
            'ee',
            new Edition(
                'orocrm',
                '3.1',
                'ce',
                '>=7.1 <7.3',
                '>=7.1 <=8.0',
            )
        );

        yield new EditionDependency(
            'orocrm',
            '4.1',
            'ee',
            new Edition(
                'orocrm',
                '4.1',
                'ce',
                '>=7.3 <8.0',
                '>=7.3 <=8.0',
            )
        );

        yield new EditionDependency(
            'orocrm',
            '4.2',
            'ee',
            new Edition(
                'orocrm',
                '4.2',
                'ce',
                '>=7.3 <8.0',
                '>=7.3 <=8.0',
            )
        );
    }
}
