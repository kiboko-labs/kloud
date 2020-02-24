<?php declare(strict_types=1);

namespace Builder\PHP;

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
        foreach ($this() as $parts) {
            yield new TagReference(strtr('%php.version%-%php.flavor%', $parts));
        }
    }

    public function __invoke(): \Traversable
    {
        /** @var FlavorInterface $flavor */
        foreach ($this->flavors as $flavor) {
            foreach ($flavor() as $parts) {
                yield $parts + [
                    '%php.version%' => $this->number,
                ];
            }
        }
    }
}