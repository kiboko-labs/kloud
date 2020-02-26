<?php declare(strict_types=1);

namespace Builder\Package;

use Builder\BuildableContext;
use Builder\BuildableContextInterface;
use Builder\BuildableDependentTag;
use Builder\Command;
use Builder\Context;
use Builder\ContextInterface;
use Builder\TagReference;

final class BuildableDependentPackage implements DependentPackageInterface, BuildablePackageInterface, \IteratorAggregate
{
    private RepositoryInterface $repository;
    public string $name;
    public string $parent;
    public string $path;
    /** @var EditionInterface[] */
    public array $editions;

    public function __construct(
        RepositoryInterface $repository,
        string $name,
        string $parent,
        string $path,
        EditionInterface ...$editions
    ) {
        $this->repository = $repository;
        $this->name = $name;
        $this->parent = $parent;
        $this->path = $path;
        $this->editions = $editions;
    }

    public function buildPath(array $variables)
    {
        return strtr($this->path, $variables);
    }

    public function pull(Command\CommandCompositeInterface $commands): void
    {
        /** @var BuildableContextInterface $context */
        foreach ($this() as $context) {
            $commands->add(new Command\Pull(
                $this->repository,
                new TagReference('%php.version%-%php.flavor%-%package.name%-%package.edition%-%package.version%-%package.variation%', $context)
            ));
        }
    }

    public function push(Command\CommandCompositeInterface $commands): void
    {
        /** @var BuildableContextInterface $context */
        foreach ($this() as $context) {
            $commands->add(new Command\Push(
                $this->repository,
                new TagReference('%php.version%-%php.flavor%-%package.name%-%package.edition%-%package.version%-%package.variation%', $context)
            ));
        }
    }

    public function build(Command\CommandCompositeInterface $commands): void
    {
        /** @var BuildableContextInterface $context */
        foreach ($this() as $context) {
            $commands->add(new Command\BuildFrom(
                $this->repository,
                new TagReference('%php.version%-%php.flavor%-%package.name%-%package.edition%-%package.version%-%package.variation%', $context),
                new TagReference(
                    '%php.version%-%php.flavor%-%package.name%-%package.edition%-%package.version%-%package.variation%',
                    new Context(['%package.name%' => $this->parent] + $context->getArrayCopy())
                ),
                (string) $context->getPath()
            ));
        }
    }

    public function getIterator()
    {
        /** @var BuildableContextInterface $context */
        foreach ($this() as $context) {
            yield new BuildableDependentTag(
                $this->repository,
                new TagReference(
                    '%php.version%-%php.flavor%-%package.name%-%package.edition%-%package.version%-%package.variation%',
                    new Context(['%package.name%' => $this->parent] + $context->getArrayCopy())
                ),
                (string) $context->getPath(),
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
                yield new BuildableContext(
                    $context,
                    $this->path,
                    [
                        '%package.name%' => $this->name,
                    ] + $context->getArrayCopy()
                );
            }
        }
    }
}