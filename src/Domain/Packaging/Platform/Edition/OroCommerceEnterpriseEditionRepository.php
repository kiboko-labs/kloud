<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Platform\Edition;

final class OroCommerceEnterpriseEditionRepository implements EditionRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield new EditionDependency(
            'orocommerce',
            '1.6',
            'ee',
            new Edition(
                'orocommerce',
                '1.6',
                'ce',
                '>=5.6 <7.2'
            )
        );

        yield new EditionDependency(
            'orocommerce',
            '3.1',
            'ee',
            new Edition(
                'orocommerce',
                '3.1',
                'ce',
                '>=7.1 <7.3',
                '>=7.1 <=8.0',
            )
        );

        yield new EditionDependency(
            'orocommerce',
            '4.1',
            'ee',
            new Edition(
                'orocommerce',
                '4.1',
                'ce',
                '>=7.3 <8.0',
                '>=7.3 <=8.0',
            )
        );
    }
}