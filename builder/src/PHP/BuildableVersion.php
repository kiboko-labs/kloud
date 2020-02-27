<?php declare(strict_types=1);

namespace Builder\PHP;

use Builder\BuildableContext;
use Builder\BuildableInterface;
use Builder\BuildableTag;
use Builder\Command;
use Builder\Command\CommandBusInterface;
use Builder\ContextInterface;
use Builder\Package\RepositoryInterface;
use Builder\PHP;
use Builder\TagReference;

final class BuildableVersion implements PHP\VersionInterface, BuildableInterface, \IteratorAggregate
{
    private RepositoryInterface $repository;
    public string $number;
    public string $path;
    /** @var FlavorInterface[] */
    public array $flavors;

    public function __construct(RepositoryInterface $repository, string $number, string $path, FlavorInterface ...$flavors)
    {
        $this->repository = $repository;
        $this->number = $number;
        $this->path = $path;
        $this->flavors = $flavors;
    }

    public function pull(CommandBusInterface $commands): void
    {
        /** @var ContextInterface $context */
        foreach ($this() as $context) {
            $commands->add(new Command\Pull(
                $this->repository,
                new TagReference('%php.version%-%php.flavor%', $context)
            ));
        }
    }

    public function push(CommandBusInterface $commands): void
    {
        /** @var ContextInterface $context */
        foreach ($this() as $context) {
            $commands->add(new Command\Push(
                $this->repository,
                new TagReference('%php.version%-%php.flavor%', $context)
            ));
        }
    }

    public function build(CommandBusInterface $commands): void
    {
        /** @var ContextInterface $context */
        foreach ($this() as $context) {
            $commands->add(new Command\Build(
                $this->repository,
                new TagReference('%php.version%-%php.flavor%', $context),
                $this->getPath()
            ));
        }
    }

    public function forceBuild(CommandBusInterface $commands): void
    {
        /** @var ContextInterface $context */
        foreach ($this() as $context) {
            $commands->add(new Command\ForceBuild(
                $this->repository,
                new TagReference('%php.version%-%php.flavor%', $context),
                $this->getPath()
            ));
        }
    }

    public function getIterator()
    {
        /** @var ContextInterface $context */
        foreach ($this() as $context) {
            yield new BuildableTag($this->repository, $this->path, '%php.version%-%php.flavor%', $context);
        }
    }

    public function __invoke(): \Traversable
    {
        /** @var FlavorInterface $flavor */
        foreach ($this->flavors as $flavor) {
            /** @var ContextInterface $context */
            foreach ($flavor() as $context) {
                yield new BuildableContext(
                    $context,
                    $this->path,
                    [
                        '%php.version%' => $this->number,
                    ] + $context->getArrayCopy()
                );
            }
        }
    }
}