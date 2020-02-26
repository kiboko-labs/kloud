<?php declare(strict_types=1);

namespace Builder\PHP;

use Builder\Context;
use Builder\ContextInterface;
use Builder\TagReference;

class VersionReference implements VersionInterface, \IteratorAggregate
{
    public string $number;
    /** @var FlavorInterface[] */
    public array $flavors;

    public function __construct(string $number, FlavorInterface ...$flavors)
    {
        $this->number = $number;
        $this->flavors = $flavors;
    }

    public function getIterator()
    {
        foreach ($this() as $context) {
            yield new TagReference('%php.version%-%php.flavor%', $context);
        }
    }

    public function __invoke(): \Traversable
    {
        /** @var FlavorInterface $flavor */
        foreach ($this->flavors as $flavor) {
            /** @var ContextInterface $context */
            foreach ($flavor() as $context) {
                yield new Context(
                    [
                        '%php.version%' => $this->number,
                    ] + $context->getArrayCopy()
                );
            }
        }
    }
}