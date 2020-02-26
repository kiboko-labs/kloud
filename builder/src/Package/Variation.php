<?php declare(strict_types=1);

namespace Builder\Package;

use Builder\Context;
use Builder\ContextInterface;
use Builder\DependentTagReference;
use Builder\PHP;
use Builder\TagReference;

final class Variation implements VariationInterface, \IteratorAggregate
{
    public string $name;
    /** @var VersionInterface[] */
    public array $versions;

    public function __construct(string $name, PHP\VersionInterface ...$versions)
    {
        $this->name = $name;
        $this->versions = $versions;
    }

    public function getIterator()
    {
        foreach ($this() as $context) {
            yield new DependentTagReference(
                new TagReference('%php.version%-%php.flavor%', $context),
                '%php.version%-%php.flavor%-%package.variation%',
                $context,
            );
        }
    }

    public function __invoke(): \Traversable
    {
        /** @var PHP\VersionInterface $version */
        foreach ($this->versions as $version) {
            /** @var ContextInterface $context */
            foreach ($version() as $context) {
                yield new Context(
                    [
                        '%package.variation%' => $this->name,
                    ] + $context->getArrayCopy()
                );
            }
        }
    }
}