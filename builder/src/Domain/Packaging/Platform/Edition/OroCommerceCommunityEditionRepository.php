<?php declare(strict_types=1);

namespace Builder\Domain\Packaging\Platform\Edition;

use Exception;
use Traversable;

final class OroCommerceCommunityEditionRepository implements EditionRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield new EditionDependency(
            'orocommerce',
            '1.6',
            'ce',
            new Edition(
                'oroplatform',
                '2.6',
                'ce'
            )
        );

        yield new EditionDependency(
            'orocommerce',
            '3.1',
            'ce',
            new Edition(
                'oroplatform',
                '3.1',
                'ce'
            )
        );

        yield new EditionDependency(
            'orocommerce',
            '4.1',
            'ce',
            new Edition(
                'oroplatform',
                '4.1',
                'ce'
            )
        );
    }
}