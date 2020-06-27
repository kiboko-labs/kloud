<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Platform\Edition;

final class OroCommerceEnterpriseEditionRepository implements EditionRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield new EditionDependency(
            'orocommerce',
            '3.1',
            'ee',
            new Edition(
                'orocommerce',
                '3.1',
                'ce',
                '>=7.1 <8.1'
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
                '>=7.3 <9.0'
            )
        );
    }
}