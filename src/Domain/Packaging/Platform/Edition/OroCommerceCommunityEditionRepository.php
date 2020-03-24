<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Platform\Edition;

use Exception;
use Traversable;

final class OroCommerceCommunityEditionRepository implements EditionRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
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