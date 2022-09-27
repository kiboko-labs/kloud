<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Platform\Edition;

final class OroPlatformEnterpriseEditionRepository implements EditionRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield new EditionDependency(
            'oroplatform',
            '1.8',
            'ee',
            new Edition(
                'oroplatform',
                '1.6',
                'ce',
                '>=5.5 <7.0'
            )
        );

        yield new EditionDependency(
            'oroplatform',
            '1.10',
            'ee',
            new Edition(
                'oroplatform',
                '1.8',
                'ce',
                '>=5.5 <7.0'
            )
        );

        yield new EditionDependency(
            'oroplatform',
            '1.12',
            'ee',
            new Edition(
                'oroplatform',
                '1.10',
                'ce',
                '>=5.5 <7.0'
            )
        );

        yield new EditionDependency(
            'oroplatform',
            '2.6',
            'ee',
            new Edition(
                'oroplatform',
                '2.6',
                'ce',
                '>=5.6 <7.2'
            )
        );

        yield new EditionDependency(
            'oroplatform',
            '3.1',
            'ee',
            new Edition(
                'oroplatform',
                '3.1',
                'ce',
                '>=7.1 <7.3',
                '>=7.1 <=8.0'
            )
        );

        yield new EditionDependency(
            'oroplatform',
            '4.1',
            'ee',
            new Edition(
                'oroplatform',
                '4.1',
                'ce',
                '>=7.3 <8.0',
                '>=7.3 <=8.0',
            )
        );

        yield new EditionDependency(
            'oroplatform',
            '4.2',
            'ee',
            new Edition(
                'oroplatform',
                '4.2',
                'ce',
                '>=7.4 <8.0',
                '>=7.4 <=8.0',
            )
        );

        yield new EditionDependency(
            'oroplatform',
            '5.0',
            'ee',
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
