<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Platform\Edition;

use Exception;
use Traversable;

final class MarelloEnterpriseEditionRepository implements EditionRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield new EditionDependency(
            'marello',
            '2.0',
            'ee',
            new Edition(
                'oroplatform',
                '3.1',
                'ee'
            )
        );

        yield new EditionDependency(
            'marello',
            '2.1',
            'ee',
            new Edition(
                'oroplatform',
                '3.1',
                'ee'
            )
        );

        yield new EditionDependency(
            'marello',
            '2.2',
            'ee',
            new Edition(
                'oroplatform',
                '3.1',
                'ee'
            )
        );

        yield new EditionDependency(
            'marello',
            '3.0',
            'ee',
            new Edition(
                'oroplatform',
                '4.1',
                'ee'
            )
        );
    }
}