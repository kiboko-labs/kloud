<?php declare(strict_types=1);

namespace Builder\PHP;

use Builder\TagReference;
use Builder\TagRepositoryInterface;

class Flavor implements FlavorInterface, \IteratorAggregate
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getIterator()
    {
        foreach ($this() as $parts) {
            yield new TagReference(strtr('%php.flavor%', $parts));
        }
    }

    public function __invoke(): \Traversable
    {
        yield [
            '%php.flavor%' => $this->name
        ];
    }
}