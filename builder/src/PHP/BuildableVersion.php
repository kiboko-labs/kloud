<?php declare(strict_types=1);

namespace Builder\PHP;

use Builder\BuildableInterface;
use Builder\BuildableTag;
use Builder\Command;
use Builder\Command\CommandInterface;
use Builder\Package\RepositoryInterface;
use Builder\PHP;
use Builder\TagInterface;
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

    public function build(): CommandInterface
    {
        $command = new Command\CommandQueue();
        /** @var TagInterface $tag */
        foreach ($this() as $parts) {
            $command->add(new Command\Build(
                $this->repository,
                new TagReference(strtr('%php.version%-%php.flavor%', $parts)),
                strtr($this->path, $parts)
            ));
        }

        return $command;
    }

    public function getIterator()
    {
        foreach ($this() as $parts) {
            yield new BuildableTag($this->repository, strtr('%php.version%-%php.flavor%', $parts), $this->path);
        }
    }

    public function __invoke(): \Traversable
    {
        /** @var FlavorInterface $flavor */
        foreach ($this->flavors as $flavor) {
            foreach ($flavor() as $parts) {
                yield $parts + [
                    '%php.version%' => $this->number,
                ];
            }
        }
    }
}