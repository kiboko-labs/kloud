<?php declare(strict_types=1);

namespace Builder\Domain\Packaging\Platform\Edition;

use Exception;
use Traversable;

final class OroCRMEditionRepository implements EditionRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield $parent = new EditionDependency(
            'orocrm',
            '1.6',
            'ce',
            new Edition(
                'oroplatform',
                '2.6',
                'ce'
            )
        );
        yield new EditionDependency(
            'orocrm',
            '1.6',
            'ee',
            $parent
        );

        yield $parent = new EditionDependency(
            'orocrm',
            '3.1',
            'ce',
            new Edition(
                'oroplatform',
                '3.1',
                'ce'
            )
        );
        yield new EditionDependency(
            'orocrm',
            '3.1',
            'ee',
            $parent
        );

        yield $parent = new EditionDependency(
            'orocrm',
            '4.1',
            'ce',
            new Edition(
                'oroplatform',
                '4.1',
                'ce'
            )
        );
        yield new EditionDependency(
            'orocrm',
            '4.1',
            'ee',
            $parent
        );
    }
}