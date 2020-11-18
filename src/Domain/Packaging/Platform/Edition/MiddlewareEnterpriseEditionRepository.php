<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Platform\Edition;

final class MiddlewareEnterpriseEditionRepository implements EditionRepositoryInterface, \IteratorAggregate
{
    public function getIterator()
    {
        yield new EditionDependency(
            'middleware',
            '1.0',
            'ee',
            new Edition(
                'middleware',
                '1.0',
                'ce',
                '>=7.4 <8.0',
                '>=7.4 <=8.0'
            )
        );
    }
}
