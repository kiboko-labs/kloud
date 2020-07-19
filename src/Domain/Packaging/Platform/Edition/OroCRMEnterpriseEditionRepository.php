<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Platform\Edition;

final class OroCRMEnterpriseEditionRepository implements EditionRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield new EditionDependency(
            'orocrm',
            '2.6',
            'ee',
            new Edition(
                'oroplatform',
                '2.6',
                'ee',
                '>=5.6 <7.2'
            )
        );

        yield new EditionDependency(
            'orocrm',
            '3.1',
            'ee',
            new Edition(
                'oroplatform',
                '3.1',
                'ee',
                '>=7.1 <7.3',
                '>=7.1 <=8.0',
            )
        );

        yield new EditionDependency(
            'orocrm',
            '4.1',
            'ee',
            new Edition(
                'oroplatform',
                '4.1',
                'ee',
                '>=7.3 <8.0',
                '>=7.3 <=8.0',
            )
        );
    }
}