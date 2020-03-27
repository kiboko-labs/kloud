<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Platform\Edition;

final class OroPlatformCommunityEditionRepository implements EditionRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield new Edition(
            'oroplatform',
            '1.8',
            'ce',
            '>=5.6 <7.0'
        );

        yield new Edition(
            'oroplatform',
            '1.10',
            'ce',
            '>=5.6 <7.0'
        );

        yield new Edition(
            'oroplatform',
            '2.6',
            'ce',
            '>=5.6 <7.2'
        );

        yield new Edition(
            'oroplatform',
            '3.1',
            'ce',
            '>=7.1 <8.0'
        );

        yield new Edition(
            'oroplatform',
            '4.1',
            'ce',
            '>=7.3 <8.0'
        );
    }
}