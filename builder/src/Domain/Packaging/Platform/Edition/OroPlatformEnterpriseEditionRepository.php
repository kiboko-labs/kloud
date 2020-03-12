<?php declare(strict_types=1);

namespace Builder\Domain\Packaging\Platform\Edition;

use Exception;
use Traversable;

final class OroPlatformEnterpriseEditionRepository implements EditionRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield new EditionDependency(
            'oroplatform',
            '3.1',
            'ee',
            new Edition(
                'oroplatform',
                '3.1',
                'ce'
            )
        );

        yield new EditionDependency(
            'oroplatform',
            '4.1',
            'ee',
            new Edition(
                'oroplatform',
                '4.1',
                'ce'
            )
        );
    }
}