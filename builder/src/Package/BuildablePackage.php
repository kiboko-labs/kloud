<?php declare(strict_types=1);

namespace Builder\Package;

use Builder\BuildableDependentTag;
use Builder\BuildableInterface;
use Builder\Command;
use Builder\Command\CommandInterface;
use Builder\DependentTag;
use Builder\TagInterface;
use Builder\TagReference;

final class BuildablePackage implements PackageInterface, BuildableInterface, \IteratorAggregate
{
    private RepositoryInterface $repository;
    public string $name;
    public string $path;
    /** @var EditionInterface[] */
    public array $editions;

    public function __construct(
        RepositoryInterface $repository,
        string $name,
        string $path,
        EditionInterface ...$editions
    ) {
        $this->repository = $repository;
        $this->name = $name;
        $this->path = $path;
        $this->editions = $editions;
    }

    public function build(): CommandInterface
    {
        $command = new Command\CommandQueue();
        /** @var TagInterface $tag */
        foreach ($this() as $parts) {
            $command->add(new Command\BuildFrom(
                $this->repository,
                new TagReference(strtr('%php.version%-%php.flavor%-%package.name%-%package.edition%-%package.version%-%package.variation%', $parts)),
                new TagReference(strtr('%php.version%-%php.flavor%', $parts)),
                strtr($this->path, $parts)
            ));
        }

        return $command;
    }

    public function getIterator()
    {
        foreach ($this() as $parts) {
            yield new BuildableDependentTag(
                $this->repository,
                strtr('%php.version%-%php.flavor%-%package.name%-%package.edition%-%package.version%-%package.variation%', $parts),
                new TagReference(strtr('%php.version%-%php.flavor%', $parts)),
                strtr($this->path, $parts)
            );
        }
    }

    public function __invoke(): \Traversable
    {
        foreach ($this->editions as $edition) {
            foreach ($edition() as $parts) {
                yield $parts + [
                    '%package.name%' => $this->name,
                ];
            }
        }
    }
}