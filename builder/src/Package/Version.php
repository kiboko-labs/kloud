<?php declare(strict_types=1);

namespace Builder\Package;

use Builder\Context;
use Builder\ContextInterface;
use Builder\DependentTagReference;
use Builder\TagReference;

final class Version implements VersionInterface, \IteratorAggregate
{
    public string $name;
    /** @var VariationInterface[] */
    public array $variations;

    public function __construct(string $name, VariationInterface ...$variations)
    {
        $this->name = $name;
        $this->variations = $variations;
    }

    public function getIterator()
    {
        foreach ($this() as $context) {
            yield new DependentTagReference(
                new TagReference('%php.version%-%php.flavor%-%package.variation%', $context),
                '%php.version%-%php.flavor%-%package.version%-%package.variation%',
                $context,
            );
        }
    }

    public function __invoke(): \Traversable
    {
        /** @var VariationInterface $variation */
        foreach ($this->variations as $variation) {
            /** @var ContextInterface $context */
            foreach ($variation() as $context) {
                yield new Context(
                    [
                        '%package.version%' => $this->name,
                    ] + $context->getArrayCopy()
                );
            }
        }
    }
}