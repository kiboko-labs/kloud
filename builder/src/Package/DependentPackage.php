<?php declare(strict_types=1);

namespace Builder\Package;

use Builder\Context;
use Builder\ContextInterface;
use Builder\DependentTagReference;
use Builder\TagReference;

final class DependentPackage implements DependentPackageInterface, \IteratorAggregate
{
    public string $name;
    public string $parent;
    /** @var EditionInterface[] */
    public array $editions;

    public function __construct(string $name, string $parent, EditionInterface ...$editions)
    {
        $this->name = $name;
        $this->parent = $parent;
        $this->editions = $editions;
    }

    public function getIterator()
    {
        /** @var ContextInterface $context */
        foreach ($this() as $context) {
            yield new DependentTagReference(
                new TagReference(
                    '%php.version%-%php.flavor%-%package.name%-%package.edition%-%package.version%-%package.variation%',
                    new Context(['%package.name%' => $this->parent] + $context->getArrayCopy())
                ),
                '%php.version%-%php.flavor%-%package.name%-%package.edition%-%package.version%-%package.variation%',
                $context,
            );
        }
    }

    public function __invoke(): \Traversable
    {
        /** @var EditionInterface $edition */
        foreach ($this->editions as $edition) {
            /** @var ContextInterface $context */
            foreach ($edition() as $context) {
                yield new Context(
                    [
                        '%package.name%' => $this->name,
                    ] + $context->getArrayCopy()
                );
            }
        }
    }
}