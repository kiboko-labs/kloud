<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Platform\Edition;

final class OroCRMCommunityEditionRepository implements EditionRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield new EditionDependency(
            'orocrm',
            '2.6',
            'ce',
            new Edition(
                'oroplatform',
                '2.6',
                'ce',
                '>=5.6 <7.2'
            )
        );

        yield new EditionDependency(
            'orocrm',
            '3.1',
            'ce',
            new Edition(
                'oroplatform',
                '3.1',
                'ce',
                '>=7.1 <7.3',
                '>=7.1 <=8.0',
            )
        );

        yield new EditionDependency(
            'orocrm',
            '4.1',
            'ce',
            new Edition(
                'oroplatform',
                '4.1',
                'ce',
                '>=7.3 <8.0',
                '>=7.3 <=8.0',
            )
        );
    }
}