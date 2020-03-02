<?php declare(strict_types=1);

namespace Builder\Package;

use Builder\BuildableContext;
use Builder\BuildableContextInterface;
use Builder\BuildableDependentTag;
use Builder\Command;
use Builder\ContextInterface;
use Builder\PHP;
use Builder\TagReference;

final class BuildableVariation implements VariationInterface, BuildablePackageInterface, \IteratorAggregate
{
    private RepositoryInterface $repository;
    public string $name;
    public ?string $path;
    /** @var PHP\VersionInterface[] */
    public array $versions;

    public function __construct(
        RepositoryInterface $repository,
        string $name,
        ?string $path,
        PHP\VersionInterface ...$versions
    ) {
        $this->repository = $repository;
        $this->name = $name;
        $this->path = $path;
        $this->versions = $versions;
    }

    public function pull(Command\CommandBusInterface $commands): void
    {
        /** @var BuildableContextInterface $context */
        foreach ($this() as $context) {
            $commands->add(new Command\Pull(
                $this->repository,
                new TagReference('%php.version%-%php.flavor%-%package.variation%', $context)
            ));
        }
    }

    public function push(Command\CommandBusInterface $commands): void
    {
        /** @var BuildableContextInterface $context */
        foreach ($this() as $context) {
            $commands->add(new Command\Push(
                $this->repository,
                new TagReference('%php.version%-%php.flavor%-%package.variation%', $context)
            ));
        }
    }

    public function build(Command\CommandBusInterface $commands): void
    {
        /** @var BuildableContextInterface $context */
        foreach ($this() as $context) {
            $commands->add(new Command\BuildFrom(
                $this->repository,
                new TagReference('%php.version%-%php.flavor%-%package.variation%', $context),
                new TagReference('%php.version%-%php.flavor%', $context),
                (string) $context->getPath()
            ));
        }
    }

    public function forceBuild(Command\CommandBusInterface $commands): void
    {
        /** @var BuildableContextInterface $context */
        foreach ($this() as $context) {
            $commands->add(new Command\ForceBuildFrom(
                $this->repository,
                new TagReference('%php.version%-%php.flavor%-%package.variation%', $context),
                new TagReference('%php.version%-%php.flavor%', $context),
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
                new TagReference('%php.version%-%php.flavor%', $context),
                (string) $context->getPath(),
                '%php.version%-%php.flavor%-%package.variation%',
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
                yield new BuildableContext(
                    $context,
                    $this->path,
                    [
                        '%package.variation%' => $this->name,
                    ] + $context->getArrayCopy()
                );
            }
        }
    }
}