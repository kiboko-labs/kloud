<?php declare(strict_types=1);

namespace Builder\Package;

use Builder\Context;
use Builder\ContextInterface;
use Builder\DependentTagReference;
use Builder\TagReference;

final class DependentEdition implements DependentEditionInterface, \IteratorAggregate
{
    public string $name;
    public string $parent;
    /** @var VersionInterface[] */
    public array $versions;

    public function __construct(string $name, string $parent, VersionInterface ...$versions)
    {
        $this->name = $name;
        $this->parent = $parent;
        $this->versions = $versions;
    }

    public function getIterator()
    {
        /** @var ContextInterface $context */
        foreach ($this() as $context) {
            yield new DependentTagReference(
                new TagReference(
                    '%php.version%-%php.flavor%-%package.edition%-%package.version%-%package.variation%',
                    new Context(['%package.edition%' => $this->parent] + $context->getArrayCopy())
                ),
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