<?php declare(strict_types=1);

namespace Builder\Package;

use Builder\Context;
use Builder\ContextInterface;
use Builder\DependentTagReference;
use Builder\TagReference;

final class Edition implements EditionInterface, \IteratorAggregate
{
    public string $name;
    /** @var VersionInterface[] */
    public array $versions;

    public function __construct(string $name, VersionInterface ...$versions)
    {
        $this->name = $name;
        $this->versions = $versions;
    }

    public function getIterator()
    {
        foreach ($this() as $context) {
            yield new DependentTagReference(
                new TagReference('%php.version%-%php.flavor%-%package.variation%', $context),
                '%php.version%-%php.flavor%-%package.edition%-%package.version%-%package.variation%',
                $context,
            );
        }
    }

    public function __invoke(): \Traversable
    {
        /** @var VersionInterface $version */
        foreach ($this->versions as $version) {
            /** @var ContextInterface $context */
            foreach ($version() as $context) {
                yield new Context(
                    [
                        '%package.edition%' => $this->name,
                    ] + $context->getArrayCopy()
                );
            }
        }
    }
}