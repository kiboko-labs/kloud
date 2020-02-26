<?php declare(strict_types=1);

namespace Builder\Package;

use Builder\Context;
use Builder\ContextInterface;
use Builder\DependentTagReference;
use Builder\TagReference;

final class Package implements PackageInterface, \IteratorAggregate
{
    public string $name;
    /** @var EditionInterface[] */
    public array $editions;

    public function __construct(string $name, EditionInterface ...$editions)
    {
        $this->name = $name;
        $this->editions = $editions;
    }

    public function getIterator()
    {
        foreach ($this() as $context) {
            yield new DependentTagReference(
                new TagReference('%php.version%-%php.flavor%-%package.variation%', $context),
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