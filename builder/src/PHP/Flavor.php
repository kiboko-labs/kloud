<?php declare(strict_types=1);

namespace Builder\PHP;

use Builder\Context;
use Builder\TagReference;

class Flavor implements FlavorInterface, \IteratorAggregate
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getIterator()
    {
        foreach ($this() as $context) {
            yield new TagReference('%php.flavor%', $context);
        }
    }

    public function __invoke(): \Traversable
    {
        yield new Context([
            '%php.flavor%' => $this->name
        ]);
    }
}