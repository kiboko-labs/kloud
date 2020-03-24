<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Platform\Edition;

use Exception;
use Traversable;

final class MarelloCommunityEditionRepository implements EditionRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield new EditionDependency(
            'marello',
            '2.0',
            'ce',
            new Edition(
                'oroplatform',
                '3.1',
                'ce'
            )
        );

        yield new EditionDependency(
            'marello',
            '2.1',
            'ce',
            new Edition(
                'oroplatform',
                '3.1',
                'ce'
            )
        );

        yield new EditionDependency(
            'marello',
            '2.2',
            'ce',
            new Edition(
                'oroplatform',
                '3.1',
                'ce'
            )
        );

        yield new EditionDependency(
            'marello',
            '3.0',
            'ce',
            new Edition(
                'oroplatform',
                '4.1',
                'ce'
            )
        );
    }
}