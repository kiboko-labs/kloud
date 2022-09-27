<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Platform\Edition;

final class OroCRMCommunityEditionRepository implements EditionRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield new EditionDependency(
            'orocrm',
            '1.6',
            'ce',
            new Edition(
                'oroplatform',
                '1.6',
                'ce',
                '>=5.4 <7.0'
            )
        );

        yield new EditionDependency(
            'orocrm',
            '1.8',
            'ce',
            new Edition(
                'oroplatform',
                '1.8',
                'ce',
                '>=5.4 <7.0'
            )
        );

        yield new EditionDependency(
            'orocrm',
            '1.10',
            'ce',
            new Edition(
                'oroplatform',
                '1.10',
                'ce',
                '>=5.4 <7.0'
            )
        );

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

        yield new EditionDependency(
            'orocrm',
            '4.2',
            'ce',
            new Edition(
                'oroplatform',
                '4.2',
                'ce',
                '>=7.4 <8.0',
                '>=7.4 <=8.0',
            )
        );

        yield new EditionDependency(
            'orocrm',
            '5.0',
            'ce',
            new Edition(
                'oroplatform',
                '5.0',
                'ce',
                '>=8.1',
                '>=8.1',
            )
        );
    }
}
