<?php declare(strict_types=1);

namespace Builder;

use Builder\Command;
use Builder\Package\RepositoryInterface;

final class BuildableDependentTag implements DependentTagInterface, BuildableTagInterface
{
    private RepositoryInterface $repository;
    private TagInterface $parent;
    private Placeholder $path;
    private Placeholder $tag;

    public function __construct(RepositoryInterface $repository, TagInterface $parent, string $path, string $tag, ?ContextInterface $variables = null)
    {
        $this->repository = $repository;
        $this->parent = $parent;
        $this->path = new Placeholder($path, ($variables === null ? [] : $variables->getArrayCopy()));
        $this->tag = new Placeholder($tag,($variables === null ? [] : $variables->getArrayCopy()));
    }

    public function getParent(): TagInterface
    {
        return $this->parent;
    }

    public function getPath(): string
    {
        return (string) $this->path;
    }

    public function pull(Command\CommandBusInterface $commands): void
    {
        $commands->add(new Command\Pull($this->repository, $this));
    }

    public function push(Command\CommandBusInterface $commands): void
    {
        $commands->add(new Command\Push($this->repository, $this));
    }

    public function build(Command\CommandBusInterface $commands): void
    {
        $commands->add(new Command\BuildFrom($this->repository, $this, $this->parent, $this->getPath()));
    }

    public function forceBuild(Command\CommandBusInterface $commands): void
    {
        $commands->add(new Command\ForceBuildFrom($this->repository, $this, $this->parent, $this->getPath()));
    }

    public function __toString()
    {
        return (string) $this->tag;
    }
}