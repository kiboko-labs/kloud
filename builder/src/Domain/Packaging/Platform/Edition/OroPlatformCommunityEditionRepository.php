<?php declare(strict_types=1);

namespace Builder\Domain\Packaging\Platform\Edition;

use Exception;
use Traversable;

final class OroPlatformCommunityEditionRepository implements EditionRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield new Edition(
            'oroplatform',
            '1.8',
            'ce'
        );

        yield new Edition(
            'oroplatform',
            '2.6',
            'ce'
        );

        yield new Edition(
            'oroplatform',
            '3.1',
            'ce'
        );

        yield new Edition(
            'oroplatform',
            '4.1',
            'ce'
        );
    }
}